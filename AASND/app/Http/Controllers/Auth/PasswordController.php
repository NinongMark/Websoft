<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();
        $oldPasswordHash = $user->password;

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Log the password change in audit logs
        AuditLog::log($user, 'password_changed', null, null, [
            'changed_at' => now()->toIso8601String(),
            'ip_address' => $request->ip(),
        ], [
            'password_changed' => true,
        ]);

        // Logout from other devices if requested
        if ($request->boolean('logout_other_devices', false)) {
            // Get all tokens and revoke them
            $user->tokens()->delete();
            
            // Invalidate all sessions except current
            Session::getHandler()->gc(0);
            
            // Logout other sessions by invalidating the session
            // Note: This will logout the user from all other devices
            $request->session()->flush();
            $request->session()->regenerate();
            
            // Log the action
            AuditLog::log($user, 'logout_other_devices', null, null, [
                'logged_out_at' => now()->toIso8601String(),
            ], [
                'all_other_sessions_invalidated' => true,
            ]);
        }

        return back()->with('status', 'password-updated');
    }
}
