<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'location',
        'is_new_device',
        'login_at',
        'login_successful',
        'failure_reason',
    ];

    protected $casts = [
        'is_new_device' => 'boolean',
        'login_at' => 'datetime',
        'login_successful' => 'boolean',
    ];

    /**
     * Get the user that owns the login log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this login was from a new device.
     */
    public function isNewDevice(): bool
    {
        return $this->is_new_device;
    }

    /**
     * Get the device info as a formatted string.
     */
    public function getDeviceInfoAttribute(): string
    {
        $info = [];
        
        if ($this->device_type) {
            $info[] = $this->device_type;
        }
        
        if ($this->browser) {
            $info[] = $this->browser;
        }
        
        if ($this->platform) {
            $info[] = $this->platform;
        }
        
        return implode(' - ', $info);
    }
}

