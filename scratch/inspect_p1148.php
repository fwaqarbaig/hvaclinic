<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Post;
use App\Models\Page;

$p1148 = Post::find(1148);
if ($p1148) {
    foreach ($p1148->getAttributes() as $k => $v) {
        if (is_string($v) && stripos($v, 'generator dubai') !== false) {
            echo "Post 1148 attribute $k contains 'generator dubai'\n";
        }
    }
}

$page61 = Page::find(61);
if ($page61) {
    foreach ($page61->getAttributes() as $k => $v) {
        if (is_string($v) && stripos($v, 'generator dubai') !== false) {
            echo "Page 61 attribute $k contains 'generator dubai'\n";
        }
    }
}
