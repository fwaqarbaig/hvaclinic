<?php

$data = json_decode(file_get_contents(__DIR__.'/../storage/generatordubai_full_data.json'), true);
echo 'TOTAL PAGES: '.count($data)."\n\n";
foreach (array_keys($data) as $url) {
    echo $url."\n";
}
