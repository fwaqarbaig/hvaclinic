<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Page;

$pages = Page::where('slug', 'like', 'services/%')->orderBy('slug')->get(['id', 'slug', 'title']);
foreach ($pages as $p) {
    echo "  /{$p->slug}/\n";
}
