<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\RedirectRule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

echo "Database status:\n";
echo 'Users: '.User::count()."\n";
echo 'Posts (total): '.Post::count().' (published: '.Post::where('status', 'published')->count().")\n";
echo 'Pages (total): '.Page::count().' (published: '.Page::where('status', 'published')->count().")\n";
echo 'Services (total): '.Service::count().' (published: '.Service::where('status', 'published')->count().")\n";
echo 'Categories: '.Category::count()."\n";
echo 'MenuItems: '.MenuItem::count()."\n";
echo 'RedirectRules: '.RedirectRule::count()."\n";

echo "\nSample Users:\n";
foreach (User::all() as $u) {
    echo "ID: {$u->id}, Name: {$u->name}, Email: {$u->email}, Role: {$u->role}\n";
}

echo "\nSample Pages:\n";
foreach (Page::where('status', 'published')->take(5)->get() as $p) {
    echo "Slug: {$p->slug}, Title: {$p->title}\n";
}

echo "\nSample Posts:\n";
foreach (Post::where('status', 'published')->take(5)->get() as $p) {
    echo "Slug: {$p->slug}, Title: {$p->title}\n";
}
