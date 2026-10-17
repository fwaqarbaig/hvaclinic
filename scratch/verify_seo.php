<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

$page = Page::where('slug', 'home')->first();
echo "--- HOME PAGE ---\n";
echo 'Title: '.$page->title."\n";
echo 'Focus Keyword: '.$page->focus_keyword."\n";
echo 'Meta Title: '.$page->meta_title."\n";
echo 'Meta Desc: '.$page->meta_description."\n";
echo 'Canonical: '.$page->canonical_url."\n";
echo 'Schema Length: '.strlen($page->schema_markup)."\n";
echo 'Schema Preview: '.substr($page->schema_markup, 0, 200)."...\n";

$post = Post::published()->first();
echo "\n--- SAMPLE POST ---\n";
echo 'Slug: '.$post->slug."\n";
echo 'Title: '.$post->title."\n";
echo 'Focus Keyword: '.$post->focus_keyword."\n";
echo 'Meta Title: '.$post->meta_title."\n";
echo 'Meta Desc: '.$post->meta_description."\n";
echo 'Canonical: '.$post->canonical_url."\n";
echo 'Schema Length: '.strlen($post->schema_markup)."\n";
echo 'Schema Preview: '.substr($post->schema_markup, 0, 200)."...\n";

$svc = Service::published()->first();
echo "\n--- SAMPLE SERVICE ---\n";
echo 'Slug: '.$svc->slug."\n";
echo 'Title: '.$svc->title."\n";
echo 'Focus Keyword: '.$svc->focus_keyword."\n";
echo 'Meta Title: '.$svc->meta_title."\n";
echo 'Schema Length: '.strlen($svc->schema_markup)."\n";
