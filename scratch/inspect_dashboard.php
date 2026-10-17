<?php

$content = file_get_contents(__DIR__.'/../resources/views/admin/dashboard.blade.php');
preg_match_all('/<img[^>]+>/', $content, $matches, PREG_OFFSET_CAPTURE);
foreach ($matches[0] as $m) {
    $line = substr_count(substr($content, 0, $m[1]), "\n") + 1;
    echo "Line {$line}: ".$m[0]."\n";
}
