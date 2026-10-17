<?php

$html = file_get_contents('https://www.recoverydata.ae/post/ssd-showing-wrong-capacity-recovery-dubai');
preg_match('/<main[^>]*>(.*?)<\/main>/is', $html, $m);
$main = $m[0] ?? '';
echo substr($main, 0, 3000).PHP_EOL;
