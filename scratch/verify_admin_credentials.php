<?php

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$user = User::find(1);
echo 'User: '.$user->email."\n";
echo 'Name: '.$user->name."\n";
echo "Password matches 'password': ".(password_verify('password', $user->password) ? 'YES' : 'NO')."\n";
echo '2FA Secret: '.($user->two_factor_secret ? 'SET' : 'NULL')."\n";
echo '2FA Confirmed At: '.($user->two_factor_confirmed_at ?? 'NULL')."\n";

// If password does not match 'password', set it
if (! password_verify('password', $user->password)) {
    $user->password = bcrypt('password');
    $user->save();
    echo "Password updated to 'password'\n";
}
