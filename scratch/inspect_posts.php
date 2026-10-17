<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

echo '=== CHECKING POSTS FOR PORTACABIN & UNRELATED TOPICS ==='.PHP_EOL;

$posts = Post::all();
echo 'Total posts: '.$posts->count().PHP_EOL;

$rentalPortacabinMatches = [];
$unrelatedMatches = [];
$missingImageMatches = [];

foreach ($posts as $post) {
    $text = strtolower($post->title.' '.$post->slug.' '.($post->summary ?? '').' '.($post->content ?? ''));

    // Check portacabin rental
    if (preg_match('/portacabin.*?(rent|hire|lease)|(rent|hire|lease).*?portacabin|porta\s*cabin.*?(rent|hire)/i', $text)) {
        $rentalPortacabinMatches[] = [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
        ];
    }

    // Check if image is missing
    if (empty($post->featured_image)) {
        $missingImageMatches[] = [
            'id' => $post->id,
            'title' => $post->title,
        ];
    }
}

echo 'Posts with Portacabin Rental: '.count($rentalPortacabinMatches).PHP_EOL;
foreach ($rentalPortacabinMatches as $m) {
    echo " - [{$m['id']}] {$m['title']} ({$m['slug']})".PHP_EOL;
}

echo 'Posts with Missing Image: '.count($missingImageMatches).PHP_EOL;
foreach ($missingImageMatches as $m) {
    echo " - [{$m['id']}] {$m['title']}".PHP_EOL;
}
