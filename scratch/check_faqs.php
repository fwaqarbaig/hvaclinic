<?php

use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

foreach (Service::all() as $s) {
    echo "Service: {$s->slug} -> FAQs found: ".count($s->faqs)."\n";
    foreach ($s->faqs as $i => $faq) {
        echo '   Q'.($i + 1).': '.$faq['question']."\n";
    }
}
