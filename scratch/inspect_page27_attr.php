<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Page;

$p = Page::find(27);
foreach ($p->getAttributes() as $k => $v) {
    if ($k === 'content' || $k === 'schema_markup') {
        echo "$k: (" . strlen((string)$v) . " chars)\n";
    } else {
        echo "$k: $v\n";
    }
}
