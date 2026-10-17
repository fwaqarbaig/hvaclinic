<?php

use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ServiceController;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$user = User::first();
Auth::login($user);

echo "=== TESTING SERVICE QUICK SEO ENDPOINT ===\n";
$service = Service::first();
if ($service) {
    $controller = new ServiceController;
    $request = Request::create(route('admin.services.quick-seo', $service), 'POST', [
        'focus_keyword' => 'rental generator in uae',
        'meta_title' => 'Commercial Diesel Generator Rental Dubai | 24/7 Power Fleet',
        'meta_description' => 'Commercial diesel generator rental in Dubai and across the UAE. Capacities 20 kVA to 2500 kVA with rapid 2-hour emergency mobilization and fuel management.',
        'schema_markup' => '{"@context":"https://schema.org","@type":"Service","name":"Commercial Diesel Generator Rental Dubai"}',
    ]);
    $response = $controller->quickSeo($request, $service);
    $data = json_decode($response->getContent(), true);
    echo 'Service Quick SEO Response: '.json_encode($data)."\n";
    $service->refresh();
    echo "Saved Service Focus Keyword: {$service->focus_keyword}\n";
    echo "Saved Service Meta Title: {$service->meta_title}\n";
    echo "Saved Service Schema Markup: {$service->schema_markup}\n";
}

echo "\n=== TESTING POST QUICK SEO ENDPOINT ===\n";
$post = Post::first();
if ($post) {
    $controller = new PostController;
    $request = Request::create(route('admin.posts.quick-seo', $post), 'POST', [
        'focus_keyword' => 'used portacabin buy in uae',
        'meta_title' => 'Used Portacabin Buy & Sell UAE | Heavy Duty Site Cabins',
        'meta_description' => 'Looking to buy or sell used portacabins in Dubai and UAE? We inspect, purchase scrap cabins, and supply certified refurbished site office units.',
        'schema_markup' => '{"@context":"https://schema.org","@type":"Article","headline":"Used Portacabin Buy & Sell UAE"}',
    ]);
    $response = $controller->quickSeo($request, $post);
    $data = json_decode($response->getContent(), true);
    echo 'Post Quick SEO Response: '.json_encode($data)."\n";
    $post->refresh();
    echo "Saved Post Focus Keyword: {$post->focus_keyword}\n";
}

echo "\n=== TESTING PAGE QUICK SEO ENDPOINT ===\n";
$page = Page::first();
if ($page) {
    $controller = new PageController;
    $request = Request::create(route('admin.pages.quick-seo', $page), 'POST', [
        'focus_keyword' => 'generator rental dubai',
        'meta_title' => 'Generator Rental in Dubai & UAE | 20 to 2500 kVA Power',
        'meta_description' => 'Reliable diesel generator hire across Dubai, Abu Dhabi, and Northern Emirates with complete fuel logistics, load banking, and 24/7 technical support.',
        'schema_markup' => '{"@context":"https://schema.org","@type":"WebPage","name":"Generator Rental Dubai"}',
    ]);
    $response = $controller->quickSeo($request, $page);
    $data = json_decode($response->getContent(), true);
    echo 'Page Quick SEO Response: '.json_encode($data)."\n";
    $page->refresh();
    echo "Saved Page Focus Keyword: {$page->focus_keyword}\n";
}
