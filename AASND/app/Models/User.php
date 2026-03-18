<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
'role', 'is_admin',
'profile_picture',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_enabled_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled_at' => 'datetime',
        ];
    }

    /**
     * Get the user's orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the user's reviews.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function disableTwoFactorForTesting(): void
    {
        $this->two_factor_secret = null;
        $this->two_factor_recovery_codes = null;
        $this->two_factor_enabled_at = null;
        $this->saveQuietly();
    }

    /**
     * Check if 2FA is enabled for the user.
     */
    public function isTwoFactorEnabled(): bool
    {
        return (bool) $this->two_factor_enabled_at;
    }



    /**
     * Enable 2FA for the user.
     */
    public function enableTwoFactor(): void
    {
        $this->two_factor_secret = null;
        $this->two_factor_recovery_codes = null;
        $this->two_factor_enabled_at = now();
        $this->save();
    }

    /**
     * Disable 2FA for the user.
     */
    public function disableTwoFactor(): void
    {
        $this->two_factor_secret = null;
        $this->two_factor_recovery_codes = null;
        $this->two_factor_enabled_at = null;
        $this->save();
    }





    /**
     * Generate email 2FA code.
     */
    public function generateEmailCode(): string
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put("2fa_email:{$this->id}", $code, now()->addMinutes(5));
        return $code;
    }

    /**
     * Verify email 2FA code.
     */
    public function verifyEmailCode(string $code): bool
    {
        $expected = Cache::get("2fa_email:{$this->id}");
        if ($expected === $code) {
            Cache::forget("2fa_email:{$this->id}");
            return true;
        }
        return false;
    }

    /**
     * Route notifications for the channel.
     */
    public function routeNotificationForMail(): string
    {
        return $this->email;
    }
}

