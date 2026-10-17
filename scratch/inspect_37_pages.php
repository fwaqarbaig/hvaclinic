<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Contracts\Console\Kernel;

$services = MenuItem::where('location', 'header')->where('title', 'Services')->first();
$items = [];
if ($services) {
    foreach ($services->children as $cat) {
        foreach ($cat->children as $sub) {
            $path = trim($sub->url, '/');
            $page = Page::where('slug', $path)->first();
            $items[] = [
                'parent_service' => $cat->title,
                'title' => $sub->title,
                'url' => $sub->url,
                'path' => $path,
                'page_found' => $page ? true : false,
                'page_id' => $page ? $page->id : null,
                'content_len' => $page ? strlen($page->content) : 0,
            ];
        }
    }
}

echo 'Found '.count($items)." sub-items under Services.\n";
foreach ($items as $i) {
    echo "Service: [{$i['parent_service']}] | Sub: {$i['title']} | Page Found: ".($i['page_found'] ? "YES (ID: {$i['page_id']}, len: {$i['content_len']})" : 'NO')."\n";
}
