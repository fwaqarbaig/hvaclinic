<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\RedirectRule;

echo "Total redirect rules: " . RedirectRule::count() . "\n";
echo "Active redirect rules: " . RedirectRule::where('is_active', true)->count() . "\n";

foreach (RedirectRule::where('is_active', true)->get() as $r) {
    echo "  {$r->source_url} -> {$r->target_url}\n";
}
