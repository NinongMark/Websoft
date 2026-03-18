<?php

namespace App\Services;

use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class DeviceDetectionService
{
    /**
     * Detect device type from user agent.
     */
    public function getDeviceType(string $userAgent): string
    {
        $userAgent = strtolower($userAgent);
        
        if (preg_match('/mobile|android|iphone|ipod|blackberry|windows phone/i', $userAgent)) {
            return 'Mobile';
        }
        
        if (preg_match('/tablet|ipad|playbook|silk/i', $userAgent)) {
            return 'Tablet';
        }
        
        return 'Desktop';
    }

    /**
     * Detect browser from user agent.
     */
    public function getBrowser(string $userAgent): string
    {
        $userAgent = strtolower($userAgent);
        
        if (preg_match('/edg/i', $userAgent)) {
            return 'Edge';
        }
        
        if (preg_match('/chrome/i', $userAgent)) {
            return 'Chrome';
        }
        
        if (preg_match('/safari/i', $userAgent)) {
            return 'Safari';
        }
        
        if (preg_match('/firefox/i', $userAgent)) {
            return 'Firefox';
        }
        
        if (preg_match('/msie|trident/i', $userAgent)) {
            return 'Internet Explorer';
        }
        
        return 'Unknown';
    }

    /**
     * Detect platform from user agent.
     */
    public function getPlatform(string $userAgent): string
    {
        $userAgent = strtolower($userAgent);
        
        if (preg_match('/windows nt 10/i', $userAgent)) {
            return 'Windows 10';
        }
        
        if (preg_match('/windows nt 11/i', $userAgent)) {
            return 'Windows 11';
        }
        
        if (preg_match('/macintosh|mac os x/i', $userAgent)) {
            return 'macOS';
        }
        
        if (preg_match('/linux/i', $userAgent)) {
            return 'Linux';
        }
        
        if (preg_match('/android/i', $userAgent)) {
            return 'Android';
        }
        
        if (preg_match('/iphone|ios/ip', $userAgent)) {
            return 'iOS';
        }
        
        return 'Unknown';
    }

    /**
     * Check if this is a new device for the user.
     */
    public function isNewDevice(User $user, string $ipAddress, string $userAgent): bool
    {
        // Check if there's any login from this IP or device in the last 30 days
        $recentLogin = LoginLog::where('user_id', $user->id)
            ->where('login_successful', true)
            ->where('created_at', '>=', now()->subDays(30))
            ->where(function ($query) use ($ipAddress, $userAgent) {
                $query->where('ip_address', $ipAddress)
                    ->orWhere('user_agent', $userAgent);
            })
            ->first();

        return $recentLogin === null;
    }

    /**
     * Log the login attempt.
     */
    public function logLogin(User $user, bool $successful, ?string $failureReason = null): LoginLog
    {
        $userAgent = Request::userAgent() ?? 'Unknown';
        $ipAddress = Request::ip();
        
        $isNewDevice = $successful ? $this->isNewDevice($user, $ipAddress, $userAgent) : false;

        return LoginLog::create([
            'user_id' => $user->id,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'device_type' => $this->getDeviceType($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'platform' => $this->getPlatform($userAgent),
            'is_new_device' => $isNewDevice,
            'login_at' => now(),
            'login_successful' => $successful,
            'failure_reason' => $failureReason,
        ]);
    }
}

