<?php

use App\Models\Page;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$p = Page::where('slug', 'home')->first();
if ($p) {
    echo "Home page found:\n";
    echo 'Title: '.$p->title."\n";
    echo 'Content length: '.strlen($p->content)."\n";
    echo 'Content preview: '.substr(strip_tags($p->content), 0, 300)."\n";
} else {
    echo "Home page not found\n";
}
