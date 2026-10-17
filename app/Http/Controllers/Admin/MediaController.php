<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\WebpConverter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    /**
     * Display the media library.
     */
    public function index(Request $request): View|JsonResponse
    {
        $search = $request->query('search');
        $type = $request->query('type');

        $query = Media::with('user')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%")
                    ->orWhere('alt_text', 'like', "%{$search}%");
            });
        }

        if ($type === 'image') {
            $query->where('mime_type', 'like', 'image/%');
        } elseif ($type === 'document') {
            $query->where('mime_type', 'like', 'application/%')
                ->orWhere('mime_type', 'like', 'text/%');
        }

        $media = $query->paginate(24)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($media);
        }

        return view('admin.media.index', compact('media', 'search', 'type'));
    }

    /**
     * Upload one or multiple media files.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $allowedMimes = 'jpeg,jpg,png,webp,gif,svg,pdf,doc,docx,xlsx,csv,zip,txt';
        $request->validate([
            'files' => ['nullable', 'array'],
            'files.*' => ['file', 'max:20480', 'mimes:'.$allowedMimes], // max 20MB
            'file' => ['nullable', 'file', 'max:20480', 'mimes:'.$allowedMimes],
        ]);

        $uploadedFiles = [];
        $filesToProcess = [];

        if ($request->hasFile('files')) {
            $filesToProcess = $request->file('files');
        } elseif ($request->hasFile('file')) {
            $filesToProcess = [$request->file('file')];
        }

        if (empty($filesToProcess)) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'No files provided.'], 422);
            }

            return back()->with('error', 'Please select a file to upload.');
        }

        $disallowedExtensions = [
            'php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'php8', 'phps', 'phar',
            'sh', 'bash', 'cgi', 'pl', 'py', 'exe', 'bat', 'cmd', 'vbs', 'jsp',
            'asp', 'aspx', 'shtml', 'env', 'htaccess', 'htpasswd', 'config', 'html', 'htm',
        ];
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'webp', 'gif', 'svg', 'pdf', 'doc', 'docx', 'xlsx', 'csv', 'zip', 'txt'];

        foreach ($filesToProcess as $file) {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = strtolower($file->getClientOriginalExtension());

            if (in_array($extension, $disallowedExtensions, true) || ! in_array($extension, $allowedExtensions, true)) {
                continue;
            }

            if ($extension === 'svg') {
                $svgContent = file_get_contents($file->getRealPath());
                if (preg_match('/<script|javascript:|onload=|onerror=|onclick=/i', $svgContent)) {
                    if ($request->wantsJson()) {
                        return response()->json(['error' => 'Security Error: Malicious script detected in SVG file.'], 422);
                    }

                    return back()->with('error', 'Security Error: Malicious SVG payload detected.');
                }
            }

            // Automatically convert images (jpg, png, bmp, gif, etc.) to WebP
            $converted = WebpConverter::convertAndStore($file, 'uploads/'.date('Y/m'), 'public');

            $mediaItem = Media::create([
                'name' => $converted['name'],
                'file_name' => $converted['file_name'],
                'file_path' => $converted['file_path'],
                'disk' => $converted['disk'],
                'mime_type' => $converted['mime_type'],
                'size' => $converted['size'],
                'dimensions' => $converted['dimensions'],
                'alt_text' => $converted['name'],
                'caption' => null,
                'user_id' => auth()->id(),
            ]);

            $uploadedFiles[] = $mediaItem;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => count($uploadedFiles).' file(s) uploaded successfully.',
                'media' => $uploadedFiles,
                'location' => $uploadedFiles[0]->url ?? '', // for TinyMCE / Quill upload
            ]);
        }

        return redirect()->route('admin.media.index')
            ->with('success', count($uploadedFiles).' file(s) uploaded successfully.');
    }

    /**
     * Update media metadata (alt text, caption, name).
     */
    public function update(Request $request, Media $medium): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string'],
        ]);

        $medium->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'media' => $medium]);
        }

        return redirect()->route('admin.media.index')
            ->with('success', 'Media information updated.');
    }

    /**
     * Delete media item.
     */
    public function destroy(Media $medium): RedirectResponse|JsonResponse
    {
        $filePath = (string) $medium->file_path;
        $disk = $medium->disk ?? 'public';

        if (Storage::disk($disk)->exists($filePath)) {
            Storage::disk($disk)->delete($filePath);
        }

        // Clean up mirror in public/storage if not a symlink
        $cleanPath = ltrim(str_replace('\\', '/', $filePath), '/');
        $publicTarget = public_path('storage/'.$cleanPath);
        if (file_exists($publicTarget) && ! is_link(public_path('storage'))) {
            @unlink($publicTarget);
        }

        $medium->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.media.index')
            ->with('success', 'Media file deleted successfully.');
    }

    /**
     * API endpoint returning recent media for the media picker modal.
     */
    public function modalList(Request $request): JsonResponse
    {
        $search = $request->query('search');

        $media = Media::latest()
            ->when($search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%");
            })
            ->take(50)
            ->get();

        return response()->json($media);
    }

    /**
     * Direct public storage fallback route serving media if routed through front controller.
     */
    public function servePublicStorage(string $path)
    {
        // Sanitize path against directory traversal
        $cleanPath = str_replace(['..', '\\'], ['', '/'], $path);
        $cleanPath = ltrim($cleanPath, '/');

        if (empty($cleanPath) || ! Storage::disk('public')->exists($cleanPath)) {
            abort(404);
        }

        // Self-heal: ensure mirrored to public/storage if missing
        $publicTarget = public_path('storage/'.$cleanPath);
        if (! file_exists($publicTarget)) {
            $dir = dirname($publicTarget);
            if (! is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
            $content = Storage::disk('public')->get($cleanPath);
            if ($content !== null) {
                @file_put_contents($publicTarget, $content);
            }
        }

        return Storage::disk('public')->response($cleanPath, null, [
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
