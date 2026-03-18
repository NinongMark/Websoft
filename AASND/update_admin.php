<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Find and update admin
$admin = User::where('role', 'admin')->first();

if ($admin) {
    $admin->email = 's.gonzales.kianmark@cmu.edu.ph';
    $admin->password = Hash::make('123');
    $admin->save();
    echo "Admin updated successfully!\n";
    echo "Email: s.gonzales.kianmark@cmu.edu.ph\n";
    echo "Password: 123\n";
} else {
    echo "No admin user found!\n";
}
