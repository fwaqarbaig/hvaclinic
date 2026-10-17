<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\File;

echo "=== MEDIA DIRECTORIES SCAN ===\n";
$scanDirs = ['public/images', 'public/uploads', 'public/assets', 'storage/app/public'];
foreach ($scanDirs as $dir) {
    if (File::isDirectory(base_path($dir))) {
        $allFiles = File::allFiles(base_path($dir));
        echo "{$dir}: ".count($allFiles)." files found.\n";
        // Show first 10 sample files
        $sample = array_slice($allFiles, 0, 10);
        foreach ($sample as $f) {
            echo '   - '.str_replace(base_path().DIRECTORY_SEPARATOR, '', $f->getPathname())."\n";
        }
    } else {
        echo "{$dir}: DIRECTORY NOT FOUND\n";
    }
}

echo "\n=== PRODUCTS (FLEET) ===\n";
foreach (Product::all() as $p) {
    $img = $p->featured_image ?? $p->image ?? 'NONE';
    $hasSchemaImg = str_contains($p->schema_markup ?? '', 'image') ? 'YES' : 'NO';
    echo "ID: {$p->id} | Slug: {$p->slug} | Image: {$img} | Schema Image: {$hasSchemaImg}\n";
}

echo "\n=== SERVICES ===\n";
foreach (Service::all() as $s) {
    $img = $s->featured_image ?? $s->image ?? 'NONE';
    $hasSchemaImg = str_contains($s->schema_markup ?? '', 'image') ? 'YES' : 'NO';
    echo "ID: {$s->id} | Slug: {$s->slug} | Image: {$img} | Schema Image: {$hasSchemaImg}\n";
}

echo "\n=== POSTS ===\n";
foreach (Post::all() as $post) {
    $img = $post->featured_image ?? $post->image ?? 'NONE';
    $hasSchemaImg = str_contains($post->schema_markup ?? '', 'image') ? 'YES' : 'NO';
    echo "ID: {$post->id} | Slug: {$post->slug} | Image: {$img} | Schema Image: {$hasSchemaImg}\n";
}

echo "\n=== PAGES ===\n";
foreach (Page::all() as $page) {
    $img = $page->featured_image ?? $page->image ?? 'NONE';
    $hasSchemaImg = str_contains($page->schema_markup ?? '', 'image') ? 'YES' : 'NO';
    echo "ID: {$page->id} | Slug: {$page->slug} | Template: {$page->template} | Image: {$img} | Schema Image: {$hasSchemaImg}\n";
}

echo "\n=== CATEGORIES ===\n";
foreach (Category::all() as $cat) {
    $img = $cat->image ?? 'NONE';
    $hasSchemaImg = str_contains($cat->schema_markup ?? '', 'image') ? 'YES' : 'NO';
    echo "ID: {$cat->id} | Slug: {$cat->slug} | Image: {$img} | Schema Image: {$hasSchemaImg}\n";
}
