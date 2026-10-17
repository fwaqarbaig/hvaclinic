<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

echo "=== CHECKING RELEVANT PAGES ===\n";
$targets = [
    'about' => ['about', 'about-us', 'about-hvac'],
    'our-team' => ['our-team', 'team'],
    'membership' => ['membership', 'memberships'],
    'certificates' => ['certificates', 'certification', 'certifications'],
    'rental-cooling' => ['services/rental-cooling', 'rental-cooling', 'rental-cooling-in-uae', 'services/rental-cooling/rental-cooling-in-uae'],
    'rental-ac' => ['services/rental-ac-in-uae', 'rental-ac-in-uae', 'services/rental-ac'],
    'wild-air-rental' => ['services/wild-air-rental-in-uae', 'wild-air-rental-in-uae', 'wild-air-rental'],
    'chiller-maintenance' => ['services/chiller-maintenance-in-uae', 'chiller-maintenance-in-uae', 'services/chiller-maintenance'],
    'rental-generator' => ['services/generator-rental-in-uae', 'generator-rental-in-uae', 'rental-generator'],
    'rental-power' => ['services/rental-power', 'rental-power', 'services/generator-maintenance-repair-in-uae', 'generator-maintenance-repair-in-uae'],
    'used-refurbished' => ['used-refurbished-equipment-in-uae', 'used-refurbished', 'used-equipment'],
    'contact' => ['contact', 'contact-us'],
];

foreach ($targets as $label => $slugs) {
    echo "\nTarget: $label\n";
    foreach ($slugs as $slug) {
        $page = Page::where('slug', $slug)->first();
        if ($page) {
            echo "  Page found: slug='$slug' -> Title: {$page->title} (status: {$page->status})\n";
        }
        $svc = Service::where('slug', $slug)->first();
        if ($svc) {
            echo "  Service found: slug='$slug' -> Title: {$svc->title}\n";
        }
    }
}

echo "\n=== ALL PAGES WITH 'team', 'member', 'cert', 'about' ===\n";
$pages = Page::where(function ($q) {
    $q->where('slug', 'like', '%team%')
        ->orWhere('slug', 'like', '%member%')
        ->orWhere('slug', 'like', '%cert%')
        ->orWhere('slug', 'like', '%about%');
})->get(['id', 'title', 'slug', 'status']);

foreach ($pages as $p) {
    echo "  Page: id={$p->id} | slug='{$p->slug}' | title='{$p->title}'\n";
}

echo "\n=== ALL PAGES WITH 'cooling', 'chiller', 'wild', 'generator', 'power', 'refurb' ===\n";
$servicesPages = Page::where(function ($q) {
    $q->where('slug', 'like', '%cool%')
        ->orWhere('slug', 'like', '%chiller%')
        ->orWhere('slug', 'like', '%wild%')
        ->orWhere('slug', 'like', '%generator%')
        ->orWhere('slug', 'like', '%power%')
        ->orWhere('slug', 'like', '%refurb%');
})->get(['id', 'title', 'slug', 'status']);

foreach ($servicesPages as $p) {
    echo "  Service Page: id={$p->id} | slug='{$p->slug}' | title='{$p->title}'\n";
}

echo "\n=== ALL SERVICES TABLE ENTRIES ===\n";
foreach (Service::all() as $s) {
    echo "  Service ID: {$s->id} | Slug: '{$s->slug}' | Title: '{$s->title}'\n";
}

echo "\n=== ALL PAGES MATCHING 'ac' OR 'air' OR 'rental' ===\n";
foreach (Page::where('slug', 'like', '%ac%')->orWhere('title', 'like', '%ac%')->orWhere('slug', 'like', '%air%')->get() as $p) {
    echo "  Page ID: {$p->id} | Slug: '{$p->slug}' | Title: '{$p->title}'\n";
}

echo "\n=== CURRENT MENU TREE ===\n";
$items = MenuItem::with('children.children')->whereNull('parent_id')->orderBy('order')->get();
foreach ($items as $item) {
    echo "Item: {$item->title} (url: {$item->url}, route: {$item->route_name}, id: {$item->id}, loc: {$item->location})\n";
    foreach ($item->children as $child) {
        echo "   -> Child: {$child->title} (url: {$child->url}, route: {$child->route_name}, id: {$child->id})\n";
        foreach ($child->children as $sub) {
            echo "       --> Sub: {$sub->title} (url: {$sub->url})\n";
        }
    }
}

echo "\n=== RECENT POSTS TEST ===\n";
$posts = Post::published()->with('categories')->latest('published_at')->take(3)->get();
echo 'Found '.$posts->count()." published posts\n";
foreach ($posts as $p) {
    echo "Post: {$p->title} | Slug: {$p->slug} | Img: {$p->featured_image} | Date: {$p->published_at}\n";
}
