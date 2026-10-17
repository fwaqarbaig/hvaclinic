<?php

function inspectJsFile($filename)
{
    $path = __DIR__.'/../storage/components_js/'.$filename;
    if (! file_exists($path)) {
        echo "File $filename not found!\n";

        return;
    }
    $content = file_get_contents($path);
    echo "=== $filename (length: ".strlen($content).") ===\n";
    // Search for headings or titles
    preg_match_all('/"([^"]{15,100})"/u', $content, $matches);
    $phrases = array_unique($matches[1]);
    $interesting = array_filter($phrases, function ($p) {
        return ! preg_match('/^[a-zA-Z0-9_\-\.\/]+$/', $p) && ! str_starts_with($p, 'var ') && ! str_starts_with($p, 'function');
    });
    $sample = array_slice($interesting, 0, 25);
    foreach ($sample as $s) {
        echo '  - '.trim($s)."\n";
    }
    echo "\n";
}

inspectJsFile('Industries-CMfciavq.js');
inspectJsFile('UsedGenerators-By9zP0rv.js');
inspectJsFile('Locations-w_au8RA4.js');
