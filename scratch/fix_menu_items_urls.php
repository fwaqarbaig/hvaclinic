<?php

use App\Models\MenuItem;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$mapping = [
    26 => '/service/rental-power',
    27 => '/service/power-plant',
    28 => '/service/amc-generator',
    29 => '/service/maintenance',
    30 => '/service/portacabin',
    31 => '/service/we-offer',
    32 => '/service/new-generators',
];

foreach ($mapping as $id => $url) {
    MenuItem::where('id', $id)->update(['url' => $url]);
    echo "Updated menu item {$id} to {$url}\n";
}

echo "Done.\n";
