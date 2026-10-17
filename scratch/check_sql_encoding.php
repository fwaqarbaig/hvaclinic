<?php

$bytes = file_get_contents('database.sql', false, null, 0, 16);
echo "First 16 bytes (hex): " . bin2hex($bytes) . "\n";
if (str_starts_with(bin2hex($bytes), 'fffe')) {
    echo "Encoding is UTF-16 LE (PowerShell default)! This breaks phpMyAdmin/MySQL import!\n";
} elseif (str_starts_with(bin2hex($bytes), 'efbbbf')) {
    echo "Encoding is UTF-8 with BOM\n";
} else {
    echo "Encoding is UTF-8 / ASCII\n";
}
