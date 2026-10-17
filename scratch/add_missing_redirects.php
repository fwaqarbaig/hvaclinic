<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\RedirectRule;

$rulesToAdd = [
    ['/services/generator-rental-in-uae/generator-repair-abu-dhabi', '/generator-repair-in-abu-dhabi/'],
    ['/services/generator-rental-in-uae/generator-repair-abu-dhabi/', '/generator-repair-in-abu-dhabi/'],
    ['/services/generator-rental-in-uae/generator-amc-uae', '/generator-amc-in-uae/'],
    ['/services/generator-rental-in-uae/generator-amc-uae/', '/generator-amc-in-uae/'],
    ['/services/generator-maintenance-repair-in-uae/generator-repair-in-dubai', '/generator-repair-dubai/'],
    ['/services/generator-maintenance-repair-in-uae/generator-repair-in-dubai/', '/generator-repair-dubai/'],
    ['/services/generator-maintenance-repair-in-uae/generator-repair-uae', '/generator-repair-in-uae/'],
    ['/services/generator-maintenance-repair-in-uae/generator-repair-uae/', '/generator-repair-in-uae/'],
    ['/services/rental-ac-in-uae/rental-ac-in-abu-dhabi', '/rental-ac-in-abu-dhabi/'],
    ['/services/rental-ac-in-uae/rental-ac-in-abu-dhabi/', '/rental-ac-in-abu-dhabi/'],
];

$count = 0;
foreach ($rulesToAdd as [$src, $tgt]) {
    $rule = RedirectRule::firstOrCreate(
        ['source_url' => $src],
        [
            'target_url' => $tgt,
            'status_code' => 301,
            'is_active' => true,
        ]
    );
    if ($rule->wasRecentlyCreated) {
        $count++;
        echo "Created rule: $src -> $tgt\n";
    } else {
        $rule->target_url = $tgt;
        $rule->status_code = 301;
        $rule->is_active = true;
        $rule->save();
        echo "Updated rule: $src -> $tgt\n";
    }
}

echo "Added/updated rules. Total active rules: " . RedirectRule::where('is_active', true)->count() . "\n";
