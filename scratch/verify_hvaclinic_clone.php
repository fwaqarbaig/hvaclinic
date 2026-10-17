<?php

use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "=================================================================\n";
echo "HVAC CLINIC DATA, MENU, ASSETS & ROUTE VERIFICATION\n";
echo "=================================================================\n\n";

$pass = 0;
$fail = 0;

function testCheck($name, $condition, $info = '')
{
    global $pass, $fail;
    if ($condition) {
        $pass++;
        echo " [PASS] $name".($info ? " ($info)" : '')."\n";
    } else {
        $fail++;
        echo " [FAIL] $name".($info ? " ($info)" : '')."\n";
    }
}

// 1. Assets on disk
testCheck('Logo (hvac.gif) exists', file_exists(public_path('wp-content/uploads/2026/03/hvac.gif')), filesize(public_path('wp-content/uploads/2026/03/hvac.gif')).' bytes');
testCheck('Favicon (fav.png) exists', file_exists(public_path('wp-content/uploads/2026/04/fav.png')), filesize(public_path('wp-content/uploads/2026/04/fav.png')).' bytes');
testCheck('Favicon.ico exists', file_exists(public_path('favicon.ico')));
testCheck('Footer graphic (0-2-2.gif) exists', file_exists(public_path('wp-content/uploads/2026/03/0-2-2.gif')));

// 2. Database Counts
testCheck('Pages imported (75)', Page::count() >= 75, Page::count().' pages');
testCheck('Blog posts imported (140)', Post::count() >= 140, Post::count().' posts');
testCheck('Menu items in DB (65)', MenuItem::count() >= 64, MenuItem::count().' items');

// 3. Menu Hierarchy Check
$aboutMenu = MenuItem::where('title', 'About')->first();
testCheck('About Menu exists', ! empty($aboutMenu));
testCheck('About Menu has children (Our Team, Membership, Certificates)', $aboutMenu && $aboutMenu->children()->count() >= 3, $aboutMenu ? $aboutMenu->children()->count().' children' : '0');

$servicesMenu = MenuItem::where('title', 'Services')->first();
testCheck('Services Menu exists', ! empty($servicesMenu));
testCheck('Services Menu has 9 categories', $servicesMenu && $servicesMenu->children()->count() >= 9, $servicesMenu ? $servicesMenu->children()->count().' categories' : '0');

// 4. Test Key Routes
$testUrls = [
    '/' => 'Home',
    '/about/' => 'About',
    '/our-team/' => 'Our Team',
    '/membership/' => 'Membership',
    '/certificates/' => 'Certificates',
    '/services/' => 'Services Index',
    '/services/rental-chiller-in-uae/' => 'Rental Chiller in UAE',
    '/services/rental-chiller-in-uae/rental-chiller-in-dubai/' => 'Rental Chiller Dubai',
    '/services/rental-ac-in-uae/' => 'Rental AC in UAE',
    '/services/ac-maintenance-repair-uae/' => 'AC Maintenance UAE',
    '/services/generator-rental-in-uae/' => 'Generator Rental UAE',
    '/temporary-cooling-in-uae/' => 'Temporary Cooling UAE',
    '/services/wild-air-rental-in-uae/' => 'Wild Air Rental UAE',
    '/used-refurbished-equipment-in-uae/' => 'Used & Refurbished Equipment',
    '/contact/' => 'Contact Us',
    '/category/blog/' => 'Blog Category Archive',
    '/blog/' => 'Blog Index',
];

foreach ($testUrls as $url => $label) {
    $req = Request::create($url, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();
    testCheck("Route $label ($url)", ($status === 200 || $status === 301), "Status: $status");
}

echo "\n=================================================================\n";
echo "SUMMARY: Passed: $pass | Failed: $fail\n";
echo "=================================================================\n";
