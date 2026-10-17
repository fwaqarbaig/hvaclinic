<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "=== Testing /login ===\n";
$req = Request::create('/login', 'GET');
$res = $kernel->handle($req);
$html = $res->getContent();

echo "Status: " . $res->getStatusCode() . "\n";
echo "Has 'Register now': " . (str_contains($html, 'Register now') ? 'YES (FAIL)' : 'NO (CLEAN)') . "\n";
echo "Has 'Generator Dubai': " . (str_contains($html, 'Generator Dubai') ? 'YES (FAIL)' : 'NO (CLEAN)') . "\n";
echo "Has 'HVAC Clinic': " . (str_contains($html, 'HVAC Clinic') ? 'YES (CLEAN)' : 'NO') . "\n";

echo "\n=== Testing /register GET ===\n";
$reqReg = Request::create('/register', 'GET');
$resReg = $kernel->handle($reqReg);
echo "Status: " . $resReg->getStatusCode() . "\n";
echo "Location: " . $resReg->headers->get('Location') . "\n";

echo "\n=== Testing /register POST ===\n";
$reqPost = Request::create('/register', 'POST', [
    'name' => 'Hacker',
    'email' => 'hacker@example.com',
    'password' => 'Pass1234!',
    'password_confirmation' => 'Pass1234!',
]);
$resPost = $kernel->handle($reqPost);
echo "Status: " . $resPost->getStatusCode() . "\n";
echo "User exists in DB: " . (\App\Models\User::where('email', 'hacker@example.com')->exists() ? 'YES (FAIL)' : 'NO (SECURE)') . "\n";
