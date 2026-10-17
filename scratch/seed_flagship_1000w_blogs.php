<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Str;

echo "========================================================\n";
echo "GENERATING 15 FLAGSHIP 1,000+ WORD HUMANIZED BLOGS\n";
echo "========================================================\n\n";

// 1. Create missing tags if needed
$newTagNames = [
    'Used Portacabins',
    'Scrap Portacabins',
    'Portacabin Buy & Sell',
    'Generator Pricing',
    'JAFZA Power',
    'Mussafah Industrial',
    'Event Power',
    'Generator Buyback',
    'Sandwich Panels',
    'Civil Defense Code',
];

$tagsMap = [];
foreach (Tag::all() as $t) {
    $tagsMap[$t->name] = $t->id;
}
foreach ($newTagNames as $name) {
    if (! isset($tagsMap[$name])) {
        $tag = Tag::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
        $tagsMap[$name] = $tag->id;
        echo "Created Tag: $name\n";
    }
}

$user = User::first() ?: User::create([
    'name' => 'Generator Dubai Engineering Team',
    'email' => 'hello@generatordubai.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
]);

$companyOrg = [
    '@type' => 'HomeAndConstructionBusiness',
    '@id' => 'https://generatordubai.com/#organization',
    'name' => 'Generator Dubai',
    'legalName' => 'Generator Dubai Temporary Power Solutions LLC',
    'alternateName' => ['Generator Rental Dubai', 'Rental Generator UAE'],
    'url' => 'https://generatordubai.com',
    'telephone' => '+971569213754',
    'email' => 'hello@generatordubai.com',
    'priceRange' => '$$$',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'Suit 44, King Faisal Street',
        'addressLocality' => 'Sharjah',
        'addressRegion' => 'Sharjah',
        'addressCountry' => 'AE',
    ],
];

echo "Ready to seed articles...\n";
