<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$pages = [
    '/about/' => 'About',
    '/our-team/' => 'Our Team',
    '/membership/' => 'Membership',
    '/certificates/' => 'Certificates',
    '/services/' => 'Services Index',
    '/contact/' => 'Contact',
    '/blog/' => 'Blog Archive',
];

foreach ($pages as $url => $name) {
    $req = Request::create($url, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();
    $html = $res->getContent();
    $hasContent = strlen($html) > 1000;
    preg_match('/<title>(.*?)<\/title>/', $html, $tm);
    $title = $tm[1] ?? 'NO TITLE';
    echo "[$status] $name ($url) - bytes: ".strlen($html)." - Title: $title\n";
}
