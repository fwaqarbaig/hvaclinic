<?php

$loc = json_decode(file_get_contents(__DIR__.'/../storage/locations.json'), true);
print_r($loc[0]);
