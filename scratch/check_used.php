<?php

$used = json_decode(file_get_contents(__DIR__.'/../storage/used_generators.json'), true);
print_r($used[0]);
print_r($used[6]);
