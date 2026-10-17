<?php

use App\Models\Page;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$page = Page::where('slug', 'home')->first();
if ($page) {
    echo "Home page found:\n";
    echo 'Title: '.$page->title."\n";
    echo 'Content length: '.strlen($page->content)."\n";
    echo "Contains 'Generator Dubai'?: ".(str_contains($page->content ?? '', 'Generator Dubai') ? 'YES' : 'NO')."\n";
    echo "First 500 chars:\n".substr($page->content, 0, 500)."\n";
} else {
    echo "No page with slug 'home'\n";
}
