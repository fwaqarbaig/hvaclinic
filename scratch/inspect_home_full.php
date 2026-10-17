<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use App\Models\Page;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$page27 = Page::find(27);
echo "=== Page 27 Database Record ===\n";
echo "ID: " . ($page27 ? $page27->id : 'null') . "\n";
echo "Title: " . ($page27 ? $page27->title : 'null') . "\n";
echo "OG Desc: " . ($page27 ? $page27->og_description : 'null') . "\n";
echo "Schema markup length: " . ($page27 && $page27->schema_markup ? strlen($page27->schema_markup) : 0) . "\n";
if ($page27 && $page27->schema_markup) {
    echo "Schema snippet: " . substr($page27->schema_markup, 0, 300) . "...\n";
}

$request = Request::create('/', 'GET');
$response = $kernel->handle($request);
$html = $response->getContent();

echo "\n=== Home HTML Inspection ===\n";
// Extract all JSON-LD scripts
preg_match_all('/<script type="application\/ld\+json"[^>]*>(.*?)<\/script>/s', $html, $matches);
echo "Count of JSON-LD scripts: " . count($matches[1]) . "\n";
foreach ($matches[1] as $idx => $script) {
    echo "--- Script #$idx ---\n";
    $json = json_decode(trim($script), true);
    if ($json) {
        if (isset($json['@graph'])) {
            echo "  @graph with " . count($json['@graph']) . " nodes:\n";
            foreach ($json['@graph'] as $node) {
                echo "    - " . ($node['@type'] ?? 'Unknown type') . " (" . ($node['@id'] ?? $node['name'] ?? 'no id/name') . ")\n";
                if (isset($node['name'])) echo "      name: " . $node['name'] . "\n";
                if (isset($node['description'])) echo "      desc: " . substr($node['description'], 0, 80) . "\n";
            }
        } else {
            echo "  Single type: " . ($json['@type'] ?? 'Unknown') . "\n";
            if (isset($json['name'])) echo "    name: " . $json['name'] . "\n";
        }
    } else {
        echo "  Invalid JSON!\n";
    }
}

// Check for stray strings
$strays = ['recoverydata', 'wp-content', 'submit-spin', 'HVACLINIC & Power Solution', 'Generator Dubai', 'category/blog'];
echo "\n=== Stray String Checks in Home HTML ===\n";
foreach ($strays as $stray) {
    $count = substr_count(strtolower($html), strtolower($stray));
    echo "Occurrences of '$stray': $count\n";
}
