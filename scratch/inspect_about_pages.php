<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Page;
use Illuminate\Contracts\Console\Kernel;

$slugs = ['about', 'our-team', 'membership', 'certificates'];
foreach ($slugs as $s) {
    $p = Page::where('slug', $s)->first();
    if ($p) {
        echo "=====================================\n";
        echo "SLUG: {$s}\n";
        echo "TITLE: {$p->title}\n";
        echo 'CONTENT LENGTH: '.strlen($p->content)."\n";
        echo "RAW CONTENT (first 1000 chars):\n";
        echo substr($p->content, 0, 1000)."\n";
        echo "=====================================\n\n";
    } else {
        echo "PAGE NOT FOUND: $s\n";
    }
}

echo "=== VIEW EXISTENCE TEST ===\n";
foreach (['about', 'our-team', 'membership', 'certificates'] as $v) {
    echo "view('frontend.pages.$v') exists? ".(view()->exists("frontend.pages.$v") ? 'YES' : 'NO')."\n";
}
