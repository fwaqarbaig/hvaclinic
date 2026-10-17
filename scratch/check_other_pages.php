<?php

$data = json_decode(file_get_contents(__DIR__.'/../storage/generatordubai_full_data.json'), true);

foreach (['industries', 'used-refurbished-generators', 'locations', 'locations/dubai', 'fleet'] as $k) {
    echo "=== PAGE: $k ===\n";
    $p = $data[$k]['props'] ?? [];
    foreach ($p as $key => $val) {
        if (! in_array($key, ['errors', 'auth', 'site', 'primaryMenu', 'flash', 'ziggy'])) {
            echo " - $key (".gettype($val).(is_array($val) ? ', count: '.count($val) : '').")\n";
            if (is_array($val) && count($val) <= 15) {
                echo '   keys: '.implode(', ', array_keys($val))."\n";
            }
        }
    }
    echo "\n";
}
