<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$consoleKernel = $app->make(Kernel::class);
$consoleKernel->bootstrap();

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

echo "Testing Admin Controller Updates for schema_markup directly:\n\n";

$admin = User::where('role', 'admin')->first() ?: User::first();
auth()->login($admin);

// 1. Post Controller
$post = Post::first();
$customPostSchema = json_encode(['@context' => 'https://schema.org', '@type' => 'BlogPosting', 'headline' => 'Custom Test Post Schema']);
$req = Request::create('/admin/posts/'.$post->id, 'PUT', [
    'title' => $post->title,
    'slug' => $post->slug,
    'status' => $post->status,
    'schema_markup' => $customPostSchema,
]);
$controller = app(PostController::class);
$res = $controller->update($req, $post);
$post->refresh();
echo 'Post Update Redirect: '.($res->isRedirect() ? 'YES' : 'NO').' | Stored Match: '.($post->schema_markup === $customPostSchema ? 'YES' : 'NO')."\n";

// 2. Page Controller
$page = Page::first();
$customPageSchema = json_encode(['@context' => 'https://schema.org', '@type' => 'WebPage', 'name' => 'Custom Test Page Schema']);
$req = Request::create('/admin/pages/'.$page->id, 'PUT', [
    'title' => $page->title,
    'slug' => $page->slug,
    'template' => $page->template,
    'status' => $page->status,
    'schema_markup' => $customPageSchema,
]);
$controller = app(PageController::class);
$res = $controller->update($req, $page);
$page->refresh();
echo 'Page Update Redirect: '.($res->isRedirect() ? 'YES' : 'NO').' | Stored Match: '.($page->schema_markup === $customPageSchema ? 'YES' : 'NO')."\n";

// 3. Service Controller
$service = Service::first();
$customServiceSchema = json_encode(['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Custom Test Service Schema']);
$req = Request::create('/admin/services/'.$service->id, 'PUT', [
    'title' => $service->title,
    'slug' => $service->slug,
    'status' => $service->status,
    'schema_markup' => $customServiceSchema,
]);
$controller = app(ServiceController::class);
$res = $controller->update($req, $service);
$service->refresh();
echo 'Service Update Redirect: '.($res->isRedirect() ? 'YES' : 'NO').' | Stored Match: '.($service->schema_markup === $customServiceSchema ? 'YES' : 'NO')."\n";

// 4. Product Controller
$product = Product::first();
$customProdSchema = json_encode(['@context' => 'https://schema.org', '@type' => 'Product', 'name' => 'Custom Test Product Schema']);
$req = Request::create('/admin/products/'.$product->id, 'PUT', [
    'title' => $product->title,
    'slug' => $product->slug,
    'status' => $product->status,
    'schema_markup' => $customProdSchema,
]);
$controller = app(ProductController::class);
$res = $controller->update($req, $product);
$product->refresh();
echo 'Product Update Redirect: '.($res->isRedirect() ? 'YES' : 'NO').' | Stored Match: '.($product->schema_markup === $customProdSchema ? 'YES' : 'NO')."\n";

// 5. Category Controller
$category = Category::first();
$customCatSchema = json_encode(['@context' => 'https://schema.org', '@type' => 'CollectionPage', 'name' => 'Custom Test Category Schema']);
$req = Request::create('/admin/categories/'.$category->id, 'PUT', [
    'name' => $category->name,
    'slug' => $category->slug,
    'schema_markup' => $customCatSchema,
]);
$controller = app(CategoryController::class);
$res = $controller->update($req, $category);
$category->refresh();
echo 'Category Update Redirect: '.($res->isRedirect() ? 'YES' : 'NO').' | Stored Match: '.($category->schema_markup === $customCatSchema ? 'YES' : 'NO')."\n";
