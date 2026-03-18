<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TwoFactorLoginNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TwoFactorController extends Controller
{
    /**
     * Enable 2FA for the user.
     */
    public function enable(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $user->enableTwoFactor();

        return redirect()->route('profile.edit')
            ->with('status', 'two-factor-enabled');
    }

    /**
     * Disable 2FA for the user.
     */
    public function disable(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        $user->disableTwoFactor();

        // Send notification
        $user->notify(new \App\Notifications\TwoFactorDisabledNotification());

        return redirect()->route('profile.edit')
            ->with('status', 'two-factor-disabled');
    }

    /**
     * Show the 2FA challenge page.
     */
    public function showChallenge(): View
    {
        // Store the user ID in session for verification
        $userId = session('two_factor_user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }

    /**
     * Verify the 2FA code.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required',
        ]);

        $userId = session('two_factor_user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::findOrFail($userId);

        if (!$user->verifyEmailCode($request->code)) {
            return back()->withErrors(['code' => 'Wrong Code, Please re-enter Code.']);
        }

        // Clear the 2FA session data
        session()->forget('two_factor_user_id');

        // Login the user
        Auth::login($user);
        session()->regenerate();

        $redirectTo = $user->isAdmin() ? route('admin.dashboard') : route('dashboard');
        return redirect()->intended($redirectTo);

    }

    /**
     * Resend 2FA code.
     */
    public function resend(Request $request): RedirectResponse
    {
        $userId = session('two_factor_user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::findOrFail($userId);
        
        $code = $user->generateEmailCode();
        $user->notify(new TwoFactorLoginNotification($code));

        return back()->with('status', 'code-sent');
    }
}

