<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

echo '=== SCANNING INTERNAL LINKS IN SERVICES ==='.PHP_EOL;

$allRoutes = collect(Route::getRoutes()->getRoutes())->map(function ($r) {
    return $r->uri();
})->toArray();

$services = Service::all();
$brokenLinks = [];

foreach ($services as $service) {
    preg_match_all('/href="([^"]+)"/', $service->content, $matches);
    foreach ($matches[1] as $href) {
        if (str_starts_with($href, 'http') && ! str_contains($href, 'generator') && ! str_contains($href, 'localhost')) {
            continue; // external link
        }
        if (str_starts_with($href, 'tel:') || str_starts_with($href, 'mailto:') || str_starts_with($href, '#')) {
            continue;
        }

        // Normalize path
        $path = parse_url($href, PHP_URL_PATH);
        $path = ltrim($path, '/');

        // Test dispatching or matching
        try {
            $req = Request::create('/'.$path, 'GET');
            $route = Route::getRoutes()->match($req);
        } catch (NotFoundHttpException $e) {
            $brokenLinks[] = [
                'source' => "Service: {$service->slug}",
                'link' => $href,
                'path' => $path,
            ];
        } catch (Throwable $e) {
            // Other error or ok
        }
    }
}

echo 'Found broken internal links in Services: '.count($brokenLinks).PHP_EOL;
foreach ($brokenLinks as $bl) {
    echo " - [{$bl['source']}] {$bl['link']}".PHP_EOL;
}
