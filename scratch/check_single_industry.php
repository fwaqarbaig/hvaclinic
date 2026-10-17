<?php

$ind = json_decode(file_get_contents(__DIR__.'/../storage/industries.json'), true);
print_r($ind[0]);
