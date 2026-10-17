<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Page;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

$s = Service::where('slug', 'portacabin')->first();
if ($s) {
    echo "=== SERVICE: portacabin ===\n";
    echo 'Title: '.$s->title."\n";
    echo 'Tagline: '.$s->tagline."\n";
    echo 'Summary: '.$s->summary."\n";
    echo 'Meta Title: '.$s->meta_title."\n";
    echo 'Meta Desc: '.$s->meta_description."\n";
    echo "Content:\n".$s->content."\n";
}

$p = Page::where('slug', 'used-refurbished-generators')->first();
if ($p) {
    echo "\n=== PAGE: used-refurbished-generators ===\n";
    echo 'Title: '.$p->title."\n";
    echo 'Meta Title: '.$p->meta_title."\n";
    echo 'Meta Desc: '.$p->meta_description."\n";
    echo "Content:\n".$p->content."\n";
}
