<?php

use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo 'Posts: '.Post::count()."\n";
echo 'Pages: '.Page::count()."\n";
echo 'Services: '.Service::count()."\n";
