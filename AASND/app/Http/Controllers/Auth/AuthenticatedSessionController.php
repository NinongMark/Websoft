<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AuditLog;
use App\Notifications\NewDeviceLoginNotification;
use App\Services\DeviceDetectionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected DeviceDetectionService $deviceDetection;

    public function __construct(DeviceDetectionService $deviceDetection)
    {
        $this->deviceDetection = $deviceDetection;
    }

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if ($user->isTwoFactorEnabled()) {
            $code = $user->generateEmailCode();
            $user->notify(new \App\Notifications\TwoFactorLoginNotification($code));
            
            session(['two_factor_user_id' => $user->id]);
            
            return redirect()->route('two-factor.challenge');
        }

        $request->session()->regenerate();

        $redirectTo = $user->isAdmin() ? route('admin.dashboard') : route('dashboard');
        return redirect()->intended($redirectTo);
    }

    public function destroy(Request $request): RedirectResponse

    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

