<?php

namespace App\Services;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WebpConverter
{
    /**
     * Convertible image extensions.
     *
     * @var array<int, string>
     */
    protected static array $convertibleExtensions = [
        'jpg', 'jpeg', 'png', 'bmp', 'gif', 'webp',
    ];

    /**
     * Convertible MIME types.
     *
     * @var array<int, string>
     */
    protected static array $convertibleMimes = [
        'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/bmp', 'image/x-ms-bmp', 'image/gif', 'image/webp',
    ];

    /**
     * Check if a file is an image that should be converted to WebP.
     */
    public static function canConvert(?string $mimeType, ?string $extension): bool
    {
        $ext = strtolower(trim((string) $extension));
        $mime = strtolower(trim((string) $mimeType));

        return in_array($ext, static::$convertibleExtensions, true)
            || in_array($mime, static::$convertibleMimes, true)
            || str_starts_with($mime, 'image/');
    }

    /**
     * Convert an uploaded file or path to WebP and store it on disk.
     *
     * @return array{
     *     name: string,
     *     file_name: string,
     *     file_path: string,
     *     disk: string,
     *     mime_type: string,
     *     size: int,
     *     dimensions: ?string,
     *     converted: bool
     * }
     */
    public static function convertAndStore(
        UploadedFile $file,
        string $subDirectory = '',
        string $disk = 'public',
        int $quality = 85
    ): array {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $originalExt = strtolower($file->getClientOriginalExtension());
        $originalMime = (string) $file->getMimeType();

        // If SVG or non-image, store without WebP conversion
        if ($originalExt === 'svg' || ! static::canConvert($originalMime, $originalExt)) {
            $safeName = Str::slug($originalName).'-'.time().'-'.Str::random(6).'.'.$originalExt;
            $dir = trim($subDirectory ?: 'uploads/'.date('Y/m'), '/');
            $path = $file->storeAs($dir, $safeName, $disk);

            static::mirrorToPublicFolder($disk, (string) $path);

            return [
                'name' => $originalName,
                'file_name' => $safeName,
                'file_path' => $path,
                'disk' => $disk,
                'mime_type' => $originalMime,
                'size' => (int) $file->getSize(),
                'dimensions' => null,
                'converted' => false,
            ];
        }

        // Attempt GD WebP conversion
        $converted = static::createWebpImage($file->getRealPath(), $quality);

        if ($converted !== null) {
            $safeName = Str::slug($originalName).'-'.time().'-'.Str::random(6).'.webp';
            $dir = trim($subDirectory ?: 'uploads/'.date('Y/m'), '/');
            $storagePath = "{$dir}/{$safeName}";

            Storage::disk($disk)->put($storagePath, $converted['data']);

            static::mirrorToPublicFolder($disk, $storagePath);

            return [
                'name' => $originalName,
                'file_name' => $safeName,
                'file_path' => $storagePath,
                'disk' => $disk,
                'mime_type' => 'image/webp',
                'size' => strlen($converted['data']),
                'dimensions' => "{$converted['width']}x{$converted['height']}",
                'converted' => true,
            ];
        }

        // Fallback: If GD fails for an edge-case file, store original
        $safeName = Str::slug($originalName).'-'.time().'-'.Str::random(6).'.'.$originalExt;
        $dir = trim($subDirectory ?: 'uploads/'.date('Y/m'), '/');
        $path = $file->storeAs($dir, $safeName, $disk);

        static::mirrorToPublicFolder($disk, (string) $path);

        return [
            'name' => $originalName,
            'file_name' => $safeName,
            'file_path' => $path,
            'disk' => $disk,
            'mime_type' => $originalMime,
            'size' => (int) $file->getSize(),
            'dimensions' => null,
            'converted' => false,
        ];
    }

    /**
     * Mirror saved file to public/storage if public/storage is a separate physical directory.
     */
    public static function mirrorToPublicFolder(string $disk, string $storagePath): void
    {
        if ($disk !== 'public' || empty($storagePath)) {
            return;
        }

        try {
            $cleanPath = ltrim(str_replace('\\', '/', $storagePath), '/');
            $publicTarget = public_path('storage/'.$cleanPath);

            if (! file_exists($publicTarget)) {
                $dir = dirname($publicTarget);
                if (! is_dir($dir)) {
                    @mkdir($dir, 0777, true);
                }

                if (Storage::disk('public')->exists($cleanPath)) {
                    $content = Storage::disk('public')->get($cleanPath);
                    if ($content !== null) {
                        @file_put_contents($publicTarget, $content);
                    }
                }
            }
        } catch (\Throwable) {
            // Fail silently to keep upload operational
        }
    }

    /**
     * Create WebP binary data and extract dimensions using PHP GD.
     *
     * @return array{data: string, width: int, height: int}|null
     */
    public static function createWebpImage(string $filePath, int $quality = 85): ?array
    {
        if (! file_exists($filePath) || ! function_exists('imagewebp')) {
            return null;
        }

        $raw = @file_get_contents($filePath);
        if ($raw === false || $raw === '') {
            return null;
        }

        // 1. Load image resource
        $image = @imagecreatefromstring($raw);
        if (! $image instanceof GdImage && ! is_resource($image)) {
            return null;
        }

        // 2. EXIF auto-rotation for mobile photos
        if (function_exists('exif_read_data')) {
            $exif = @exif_read_data($filePath);
            if (! empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3:
                        $rotated = imagerotate($image, 180, 0);
                        if ($rotated !== false) {
                            imagedestroy($image);
                            $image = $rotated;
                        }
                        break;
                    case 6:
                        $rotated = imagerotate($image, -90, 0);
                        if ($rotated !== false) {
                            imagedestroy($image);
                            $image = $rotated;
                        }
                        break;
                    case 8:
                        $rotated = imagerotate($image, 90, 0);
                        if ($rotated !== false) {
                            imagedestroy($image);
                            $image = $rotated;
                        }
                        break;
                }
            }
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width <= 0 || $height <= 0) {
            imagedestroy($image);

            return null;
        }

        // 3. Proportional downscaling for oversized images (max 2560px for web performance)
        $maxDimension = 2560;
        if ($width > $maxDimension || $height > $maxDimension) {
            $scale = min($maxDimension / $width, $maxDimension / $height);
            $newWidth = max(1, (int) round($width * $scale));
            $newHeight = max(1, (int) round($height * $scale));

            $resized = imagecreatetruecolor($newWidth, $newHeight);
            if ($resized instanceof GdImage || is_resource($resized)) {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($image);
                $image = $resized;
                $width = $newWidth;
                $height = $newHeight;
            }
        }

        // 4. Ensure true color and preserve transparency for PNG/GIF
        if (! imageistruecolor($image)) {
            imagepalettetotruecolor($image);
        }

        imagealphablending($image, true);
        imagesavealpha($image, true);

        // 5. Buffer WebP stream output
        ob_start();
        $success = imagewebp($image, null, max(10, min(100, $quality)));
        $webpData = ob_get_clean();

        imagedestroy($image);

        if (! $success || empty($webpData)) {
            return null;
        }

        return [
            'data' => $webpData,
            'width' => $width,
            'height' => $height,
        ];
    }
}
