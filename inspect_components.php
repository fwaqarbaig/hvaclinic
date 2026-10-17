<?php

foreach (glob('storage/components_js/*.js') as $f) {
    $content = file_get_contents($f);
    echo '=== '.basename($f)." ===\n";
    if (preg_match_all('/(?:title|name|heading|badge|description|paragraph_1|paragraph_2)\s*:\s*[`"\']([^`"\']{15,150})[`"\']/', $content, $m)) {
        $unique = array_unique($m[1]);
        foreach (array_slice($unique, 0, 8) as $str) {
            echo '  - '.$str."\n";
        }
    }
}
