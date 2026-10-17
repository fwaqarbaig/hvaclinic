<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\Frontend\ServiceController;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

echo '=== SERVICES STATUS ==='.PHP_EOL;
foreach (Service::all() as $s) {
    $faqCount = is_array($s->faqs) ? count($s->faqs) : 0;
    echo sprintf(
        '%-30s | Status: %-10s | Len: %-5d | SEO: %-3d | KW: %-25s | FAQs: %d'.PHP_EOL,
        $s->slug,
        $s->status,
        strlen($s->content),
        $s->seo_score ?? 0,
        substr($s->focus_keyword ?? 'N/A', 0, 25),
        $faqCount
    );
}

echo PHP_EOL.'=== TESTING FRONTEND SERVICE VIEWS ==='.PHP_EOL;
$controller = new ServiceController;

try {
    $req = Request::create('/services', 'GET');
    $indexView = $controller->index($req);
    $renderedIndex = $indexView->render();
    echo '[OK] Services Index View rendered successfully (len: '.strlen($renderedIndex).').'.PHP_EOL;
} catch (Throwable $e) {
    echo '[FAIL] Services Index: '.$e->getMessage().PHP_EOL;
}

$slugs = ['rental-power', 'power-plant', 'amc-generator', 'maintenance', 'portacabin', 'we-offer', 'new-generators', 'used-refurbished-generators'];
foreach ($slugs as $slug) {
    try {
        $view = $controller->show($slug);
        $rendered = $view->render();
        $hasSchema = str_contains($rendered, 'application/ld+json');
        $hasFaqSchema = str_contains($rendered, 'FAQPage');
        $hasBreadcrumb = str_contains($rendered, 'BreadcrumbList');
        echo "[OK] Service {$slug}: Rendered OK (len: ".strlen($rendered).', Schema: '.($hasSchema ? 'YES' : 'NO').', FAQ: '.($hasFaqSchema ? 'YES' : 'NO').', Breadcrumb: '.($hasBreadcrumb ? 'YES' : 'NO').')'.PHP_EOL;
    } catch (Throwable $e) {
        echo "[FAIL] Service {$slug}: ".$e->getMessage().' at '.$e->getFile().':'.$e->getLine().PHP_EOL;
    }
}

echo PHP_EOL.'=== TESTING ADMIN DASHBOARD VIEW ==='.PHP_EOL;
try {
    $dashView = view('admin.dashboard', [
        'stats' => [
            'total_services' => Service::count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'average_seo_score' => round(Service::avg('seo_score') ?? 0),
        ],
        'services' => Service::latest()->take(10)->get(),
        'recentPosts' => Post::latest()->take(5)->get(),
        'recentPages' => collect([]),
        'recentMedia' => collect([]),
    ])->render();
    echo '[OK] Admin Dashboard View rendered OK (len: '.strlen($dashView).')'.PHP_EOL;
    echo '     Has Focus Keyword Col: '.(str_contains($dashView, 'Focus Keyword') ? 'YES' : 'NO').PHP_EOL;
    echo '     Has SEO Signal Col: '.(str_contains($dashView, 'SEO Signal') ? 'YES' : 'NO').PHP_EOL;
    echo '     Has Quick SEO Modal: '.(str_contains($dashView, 'quickSeoModal') ? 'YES' : 'NO').PHP_EOL;
} catch (Throwable $e) {
    echo '[FAIL] Admin Dashboard: '.$e->getMessage().' at '.$e->getFile().':'.$e->getLine().PHP_EOL;
}
