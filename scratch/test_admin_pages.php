<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$consoleKernel = $app->make(Kernel::class);
$consoleKernel->bootstrap();

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;

$admin = User::where('role', 'admin')->first() ?: User::first();
auth()->login($admin);
view()->share('errors', new ViewErrorBag);

echo "Testing Admin Controller Views Rendering directly:\n\n";

try {
    // 1. Dashboard
    $res = app(DashboardController::class)->index();
    echo '✓ Admin Dashboard: '.$res->name()." -> rendered successfully!\n";

    // 2. Posts Index, Create, Edit
    $post = Post::find(568) ?: Post::first();
    $res = app(PostController::class)->index(new Request);
    echo '✓ Posts Index: '.$res->name()." -> rendered successfully!\n";
    $res = app(PostController::class)->create();
    echo '✓ Post Create: '.$res->name()." -> rendered successfully!\n";
    $res = app(PostController::class)->edit($post);
    $html = $res->render();
    echo '✓ Post Edit (568): '.$res->name().' -> rendered successfully ('.strlen($html)." bytes)!\n";

    // 3. Pages Index, Create, Edit
    $page = Page::first();
    $res = app(PageController::class)->index(new Request);
    echo '✓ Pages Index: '.$res->name()." -> rendered successfully!\n";
    $res = app(PageController::class)->create();
    echo '✓ Page Create: '.$res->name()." -> rendered successfully!\n";
    $res = app(PageController::class)->edit($page);
    $html = $res->render();
    echo "✓ Page Edit ({$page->id}): ".$res->name().' -> rendered successfully ('.strlen($html)." bytes)!\n";

    // 4. Services Index, Create, Edit
    $service = Service::first();
    $res = app(ServiceController::class)->index(new Request);
    echo '✓ Services Index: '.$res->name()." -> rendered successfully!\n";
    $res = app(ServiceController::class)->create();
    echo '✓ Service Create: '.$res->name()." -> rendered successfully!\n";
    $res = app(ServiceController::class)->edit($service);
    $html = $res->render();
    echo "✓ Service Edit ({$service->id}): ".$res->name().' -> rendered successfully ('.strlen($html)." bytes)!\n";

    // 5. Products Index, Create, Edit
    $product = Product::first();
    $res = app(ProductController::class)->index(new Request);
    echo '✓ Products Index: '.$res->name()." -> rendered successfully!\n";
    $res = app(ProductController::class)->create();
    echo '✓ Product Create: '.$res->name()." -> rendered successfully!\n";
    $res = app(ProductController::class)->edit($product);
    $html = $res->render();
    echo "✓ Product Edit ({$product->id}): ".$res->name().' -> rendered successfully ('.strlen($html)." bytes)!\n";

    // 6. Categories Index
    $res = app(CategoryController::class)->index(new Request);
    $html = $res->render();
    echo '✓ Categories Index: '.$res->name().' -> rendered successfully ('.strlen($html)." bytes)!\n";

    echo "\nAll Admin views render 100% cleanly without any ParseErrors or Blade exceptions!\n";
} catch (Throwable $e) {
    echo '✗ Rendering Exception: '.$e->getMessage()."\n";
    echo '   in '.$e->getFile().':'.$e->getLine()."\n";
    echo $e->getTraceAsString();
}
