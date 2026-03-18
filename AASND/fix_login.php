<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// Reset admin
$admin = User::where('email', 's.gonzales.kianmark@cmu.edu.ph')->first();
if ($admin) {
    $admin->password = Hash::make('123');
    $admin->two_factor_secret = null;
    $admin->two_factor_recovery_codes = null;
    $admin->two_factor_enabled_at = null;
    $admin->save();
    echo "✅ Admin FIXED! Email: s.gonzales.kianmark@cmu.edu.ph Password: 123\n";
    echo "✅ 2FA DISABLED\n";
} else {
    echo "❌ Admin not found!\n";
}

echo "Run: php fix_login.php && php artisan serve\n";
?>

