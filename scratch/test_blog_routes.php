<?php

use App\Models\Post;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$posts = Post::published()->take(5)->get();
foreach ($posts as $post) {
    $url = '/'.$post->slug.'/';
    $req = Request::create($url, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();
    echo "Post [{$post->id}] '{$post->title}' ($url) -> HTTP $status (bytes: ".strlen($res->getContent()).")\n";
}
