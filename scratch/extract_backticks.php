<?php

function extractBackticks($filename)
{
    $path = __DIR__.'/../storage/components_js/'.$filename;
    $content = file_get_contents($path);
    echo "=====================================================\n";
    echo "FILE: $filename\n";
    echo "=====================================================\n";
    preg_match_all('/`([^`]{20,300})`/u', $content, $matches);
    $phrases = array_unique($matches[1]);
    $sample = array_slice($phrases, 0, 30);
    foreach ($sample as $s) {
        echo '- '.trim(str_replace(["\n", "\r"], ' ', $s))."\n";
    }
    echo "\n";
}

extractBackticks('Industries-CMfciavq.js');
extractBackticks('Locations-w_au8RA4.js');
extractBackticks('UsedGenerators-By9zP0rv.js');
