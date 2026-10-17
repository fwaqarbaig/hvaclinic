<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

echo "=== 1. SEARCHING DATABASE FOR PORTACABIN RENTAL/RENT/HIRE ===\n";

// Services
foreach (Service::all() as $s) {
    $text = $s->title.' '.$s->tagline.' '.$s->summary.' '.$s->content.' '.$s->meta_title.' '.$s->meta_description;
    if (preg_match('/portacabin.*(rent|hire)|(rent|hire).*portacabin/i', $text, $m)) {
        echo "SERVICE [{$s->id}] {$s->title} (slug: {$s->slug}): Matches '{$m[0]}'\n";
    }
}

// Pages
foreach (Page::all() as $p) {
    $text = $p->title.' '.$p->content.' '.$p->meta_title.' '.$p->meta_description;
    if (preg_match('/portacabin.*(rent|hire)|(rent|hire).*portacabin/i', $text, $m)) {
        echo "PAGE [{$p->id}] {$p->title} (slug: {$p->slug}): Matches '{$m[0]}'\n";
    }
}

// Posts
foreach (Post::all() as $po) {
    $text = $po->title.' '.$po->slug.' '.$po->excerpt.' '.$po->meta_title.' '.$po->meta_description;
    if (preg_match('/portacabin.*(rent|hire)|(rent|hire).*portacabin/i', $text, $m)) {
        echo "POST [{$po->id}] {$po->title} (slug: {$po->slug}): Matches '{$m[0]}'\n";
    }
}

// Menu items
if (DB::getSchemaBuilder()->hasTable('menu_items')) {
    foreach (DB::table('menu_items')->get() as $mi) {
        $text = $mi->title.' '.$mi->url;
        if (preg_match('/portacabin.*(rent|hire)|(rent|hire).*portacabin/i', $text, $m)) {
            echo "MENU ITEM [{$mi->id}] {$mi->title} -> {$mi->url}\n";
        }
    }
}

echo "\n=== 2. SEARCHING BLADE VIEWS FOR PORTACABIN RENTAL/RENT/HIRE ===\n";
$viewFiles = File::allFiles(resource_path('views'));
foreach ($viewFiles as $vf) {
    $content = file_get_contents($vf->getRealPath());
    if (preg_match_all('/.{0,40}(portacabin.*?(rent|hire)|(rent|hire).*?portacabin).{0,40}/i', $content, $matches)) {
        echo 'VIEW: '.$vf->getRelativePathname()."\n";
        foreach ($matches[0] as $match) {
            echo '   -> '.trim($match)."\n";
        }
    }
}
