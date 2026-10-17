<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        // Generate slugs for any existing users
        foreach (User::all() as $user) {
            $base = Str::slug($user->name) ?: 'user-'.$user->id;
            $slug = $base;
            $counter = 1;
            while (User::where('slug', $slug)->where('id', '!=', $user->id)->exists()) {
                $slug = "{$base}-{$counter}";
                $counter++;
            }
            $user->updateQuietly(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
