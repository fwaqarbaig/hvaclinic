<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Post;
use App\Models\Page;

$replacements = [
    'Gas Generator Dubai' => 'Gas Generator in Dubai',
    'Diesel Generator Dubai' => 'Diesel Generator in Dubai',
    'Rental Generator Dubai' => 'Rental Generator in Dubai',
    'permit for generator Dubai' => 'permit for generator in Dubai',
    'rent a generator Dubai' => 'rent a generator in Dubai',
    'Rent a Generator Dubai' => 'Rent a Generator in Dubai',
    'generator Dubai' => 'generator in Dubai',
    'Generator Dubai' => 'Generator in Dubai',
];

$postIds = [1084, 1088, 1093, 1103, 1148];
foreach ($postIds as $id) {
    $p = Post::find($id);
    if ($p) {
        $content = $p->content;
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        $p->content = $content;
        $p->save();
        echo "Updated Post $id ({$p->slug})\n";
    }
}

$page61 = Page::find(61);
if ($page61) {
    $content = $page61->content;
    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    $page61->content = $content;
    $page61->save();
    echo "Updated Page 61 ({$page61->slug})\n";
}
