<?php

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo 'Total Posts in DB: '.Post::count()."\n";
echo "Sample 5 Posts:\n";
foreach (Post::take(5)->get() as $p) {
    echo " - ID: {$p->id} | {$p->title} | Slug: {$p->slug}\n";
}

$data = json_decode(file_get_contents(__DIR__.'/../storage/generatordubai_full_data.json'), true);
echo "\nBlog in scraped data? ".(isset($data['blog']) ? 'YES' : 'NO')."\n";
if (isset($data['blog'])) {
    $props = $data['blog']['props'] ?? [];
    echo 'Blog props keys: '.implode(', ', array_keys($props))."\n";
    if (isset($props['posts'])) {
        $pData = $props['posts']['data'] ?? $props['posts'];
        echo 'Posts count in scraped generatordubai: '.(is_array($pData) ? count($pData) : 'not array')."\n";
        if (is_array($pData) && count($pData) > 0) {
            foreach (array_slice($pData, 0, 5) as $sp) {
                echo '   * '.($sp['title'] ?? '').' ('.($sp['slug'] ?? '').")\n";
            }
        }
    }
}
