<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

$user = User::where('role', 'admin')->first();
auth()->login($user);

$request = Request::create('/admin/sitemaps', 'GET');
$response = $kernel->handle($request);
echo '/admin/sitemaps status: '.$response->getStatusCode()."\n";
echo 'Content length: '.strlen($response->getContent())."\n";

$resubmitRequest = Request::create('/admin/sitemaps/resubmit', 'POST');
$resubmitResponse = $kernel->handle($resubmitRequest);
echo '/admin/sitemaps/resubmit status: '.$resubmitResponse->getStatusCode().' -> '.$resubmitResponse->headers->get('Location')."\n";
