<?php

namespace App\Models;

use App\Services\GoogleTwoFactorService;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user): void {
            if (empty($user->slug) && ! empty($user->name)) {
                $baseSlug = Str::slug($user->name);
                $slug = $baseSlug ?: 'author';
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug.'-'.$counter;
                    $counter++;
                }
                $user->slug = $slug;
            }
        });

        static::deleting(function (User $user): void {
            // Safety net: if user is deleted directly, ensure any remaining posts,
            // pages, or media are attributed to an admin rather than lost or orphaned.
            $fallbackAdminId = auth()->id()
                ?? static::query()->where('role', 'admin')->where('id', '!=', $user->id)->value('id')
                ?? static::query()->where('id', '!=', $user->id)->value('id');

            if ($fallbackAdminId) {
                Post::where('user_id', $user->id)->update(['user_id' => $fallbackAdminId]);
                Page::where('user_id', $user->id)->update(['user_id' => $fallbackAdminId]);
                Media::where('user_id', $user->id)->update(['user_id' => $fallbackAdminId]);
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'password',
        'role',
        'bio',
        'avatar',
        'is_active',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'two_factor_secret' => 'encrypted',
            'two_factor_recovery_codes' => 'encrypted:array',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    /**
     * Check if user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is an editor.
     */
    public function isEditor(): bool
    {
        return in_array($this->role, ['admin', 'editor']);
    }

    /**
     * Check if user can manage content.
     */
    public function canManageContent(): bool
    {
        return $this->is_active && in_array($this->role, ['admin', 'editor', 'author']);
    }

    /**
     * Posts authored by the user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Pages authored by the user.
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Media uploaded by the user.
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * User avatar URL or placeholder.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return str_starts_with($this->avatar, 'http')
                ? $this->avatar
                : asset('storage/'.$this->avatar);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=0284c7&color=fff&size=128';
    }

    /**
     * Check if user has active two-factor authentication.
     */
    public function hasTwoFactorEnabled(): bool
    {
        return ! empty($this->two_factor_secret) && ! is_null($this->two_factor_confirmed_at);
    }

    /**
     * Verify a 6-digit Google Authenticator code for this user.
     */
    public function verifyTwoFactorCode(string $code): bool
    {
        if (empty($this->two_factor_secret)) {
            return false;
        }

        return app(GoogleTwoFactorService::class)->verifyCode($this->two_factor_secret, $code);
    }

    /**
     * Verify and consume a single-use recovery code.
     */
    public function verifyTwoFactorRecoveryCode(string $code): bool
    {
        $normalizedCode = strtolower(trim($code));
        $codes = $this->two_factor_recovery_codes ?? [];

        if (! is_array($codes) || empty($codes)) {
            return false;
        }

        foreach ($codes as $index => $recoveryCode) {
            if (hash_equals(strtolower(trim($recoveryCode)), $normalizedCode)) {
                // Remove used code to ensure single-use security
                unset($codes[$index]);
                $this->two_factor_recovery_codes = array_values($codes);
                $this->save();

                return true;
            }
        }

        return false;
    }

    /**
     * Generate and persist a fresh set of recovery codes.
     *
     * @return list<string>
     */
    public function generateTwoFactorRecoveryCodes(): array
    {
        $codes = app(GoogleTwoFactorService::class)->generateRecoveryCodes(8);
        $this->two_factor_recovery_codes = $codes;
        $this->save();

        return $codes;
    }

    /**
     * Reset and disable two-factor authentication.
     */
    public function resetTwoFactor(): void
    {
        $this->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();
    }
}
