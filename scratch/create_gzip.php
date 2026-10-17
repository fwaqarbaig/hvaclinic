<?php

$data = file_get_contents('database.sql');
file_put_contents('database.sql.gz', gzencode($data, 9));
echo "Gz created successfully.\n";
