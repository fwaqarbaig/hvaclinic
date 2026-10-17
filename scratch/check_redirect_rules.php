<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\RedirectRule;

$rules = RedirectRule::where('source_url', 'like', '%location%')
    ->orWhere('source_url', 'like', '%rental-chiller%')
    ->get(['id', 'source_url', 'target_url', 'status_code', 'is_active']);

echo "Matching redirect rules: " . $rules->count() . "\n";
foreach ($rules as $r) {
    echo "  {$r->source_url} -> {$r->target_url} ({$r->status_code})\n";
}
