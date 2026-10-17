<?php

$dir = new RecursiveDirectoryIterator(__DIR__.'/../resources/views');
$iterator = new RecursiveIteratorIterator($dir);

$patterns = [
    "route('about')",
    "route('contact')",
    "route('product.",
    'href="/about"',
    'href="/contact"',
    'href="/products"',
    'href="/services/',
    'href="/used-generators"',
];

$matches = [];
foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $content = file_get_contents($file->getPathname());
        $lines = explode("\n", $content);
        foreach ($lines as $i => $line) {
            foreach ($patterns as $p) {
                if (str_contains($line, $p)) {
                    $rel = str_replace(realpath(__DIR__.'/..').DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $matches[] = "$rel:".($i + 1).' -> '.trim($line);
                }
            }
        }
    }
}

echo 'Found '.count($matches)." occurrences:\n";
foreach (array_slice($matches, 0, 50) as $m) {
    echo $m."\n";
}
if (count($matches) > 50) {
    echo '... and '.(count($matches) - 50)." more.\n";
}
