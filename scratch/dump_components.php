<?php

function extractDataFromJs($filename, $outJsonName)
{
    $path = __DIR__.'/../storage/components_js/'.$filename;
    $content = file_get_contents($path);
    file_put_contents(__DIR__.'/../storage/'.$outJsonName.'.txt', $content);
    echo "Saved raw to storage/{$outJsonName}.txt\n";
}

extractDataFromJs('Industries-CMfciavq.js', 'industries_raw');
extractDataFromJs('Locations-w_au8RA4.js', 'locations_raw');
extractDataFromJs('UsedGenerators-By9zP0rv.js', 'used_generators_raw');
extractDataFromJs('LocationDetail-BWGaPbL8.js', 'location_detail_raw');
