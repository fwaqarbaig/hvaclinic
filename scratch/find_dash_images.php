<?php

$content = file_get_contents(__DIR__.'/../resources/views/admin/dashboard.blade.php');
$lines = explode("\n", $content);
foreach ($lines as $i => $line) {
    if (str_contains($line, '<img') || str_contains($line, 'avatar') || str_contains($line, 'featured_image') || str_contains($line, 'recentMedia') || str_contains($line, 'url')) {
        echo 'Line '.($i + 1).': '.trim($line)."\n";
    }
}
