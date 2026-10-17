<?php

use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

foreach (Service::all() as $s) {
    echo "========================================\n";
    echo "ID: {$s->id} | Slug: {$s->slug}\n";
    echo "Title: {$s->title}\n";
    echo "Tagline: {$s->tagline}\n";
    echo "Focus Keyword: {$s->focus_keyword}\n";
    echo "Meta Title: {$s->meta_title}\n";
    echo "Meta Desc: {$s->meta_description}\n";
    echo "SEO Score: {$s->seo_score}\n";
    echo 'Content Length: '.strlen($s->content ?? '')." bytes\n";
    echo 'Features Count: '.count($s->features ?? [])."\n";
    echo 'Benefits Count: '.count($s->benefits ?? [])."\n";
    echo 'Benchmarks: '.json_encode($s->benchmarks)."\n";
}
