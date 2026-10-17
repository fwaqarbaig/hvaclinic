<?php

use App\Models\Page;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$checkSlugs = [
    'about' => 'Page about',
    'our-team' => 'Page our-team',
    'membership' => 'Page membership',
    'certificates' => 'Page certificates',
    'services' => 'Page services',
    'contact' => 'Page contact',
    'services/rental-chiller-in-uae' => 'Service / Page rental chiller',
    'services/rental-chiller-in-uae/rental-chiller-in-dubai' => 'Subpage rental chiller dubai',
    'services/rental-chiller-in-uae/rental-chiller-in-abu-dhabi' => 'Subpage rental chiller abu dhabi',
    'services/rental-chiller-in-uae/rental-chiller-in-sharjah' => 'Subpage rental chiller sharjah',
    'services/rental-chiller-in-uae/industrial-chiller-rental-in-uae' => 'Subpage industrial chiller',
    'services/rental-chiller-in-uae/air-cooled-chiller-rental-in-uae' => 'Subpage air cooled chiller',
    'services/rental-chiller-in-uae/water-cooled-chiller-in-uae' => 'Subpage water cooled chiller',
    'services/rental-chiller-in-uae/emergency-chiller-rental-in-uae' => 'Subpage emergency chiller',
];

foreach ($checkSlugs as $slug => $label) {
    $p = Page::where('slug', $slug)->first();
    $s = Service::where('slug', $slug)->orWhere('slug', basename($slug))->first();
    echo "$label ($slug): ".($p ? "Found Page #{$p->id} '{$p->title}'" : ($s ? "Found Service #{$s->id} '{$s->title}'" : 'NOT FOUND'))."\n";
}
