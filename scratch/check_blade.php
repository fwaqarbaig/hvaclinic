<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Blade;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$views = [
    'resources/views/admin/dashboard.blade.php',
    'resources/views/admin/partials/quick-seo-modal.blade.php',
    'resources/views/admin/partials/yoast-seo-box.blade.php',
    'resources/views/admin/posts/form.blade.php',
    'resources/views/admin/pages/form.blade.php',
    'resources/views/admin/services/form.blade.php',
];

$hasError = false;
foreach ($views as $viewPath) {
    $full = realpath(__DIR__.'/../'.$viewPath);
    if (! $full || ! file_exists($full)) {
        echo "MISSING: $viewPath\n";
        $hasError = true;

        continue;
    }
    try {
        $content = file_get_contents($full);
        Blade::compileString($content);
        echo "OK: $viewPath\n";
    } catch (Throwable $e) {
        echo "ERROR in $viewPath: ".$e->getMessage()."\n";
        $hasError = true;
    }
}

if (! $hasError) {
    echo "\nALL BLADE TEMPLATES COMPILED SUCCESSFULLY!\n";
}
