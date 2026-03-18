<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the entity that was modified.
     */
    public function entity()
    {
        if ($this->entity_type && $this->entity_id) {
            return $this->morphTo('entity', 'entity_type', 'entity_id');
        }
        return null;
    }

    /**
     * Log an action.
     */
    public static function log(
        ?User $user,
        string $action,
        ?string $entityType = null,
        ?int $entityId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): self {
        return self::create([
            'user_id' => $user?->id,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get human-readable action description.
     */
    public function getActionDescriptionAttribute(): string
    {
        return match($this->action) {
            'create' => 'Created',
            'update' => 'Updated',
            'delete' => 'Deleted',
            'login' => 'Logged in',
            'logout' => 'Logged out',
            'password_changed' => 'Changed password',
            '2fa_enabled' => 'Enabled 2FA',
            '2fa_disabled' => 'Disabled 2FA',
            'email_verified' => 'Verified email',
            'order_placed' => 'Placed order',
            'order_status_changed' => 'Changed order status',
            'review_created' => 'Created review',
            default => ucfirst($this->action),
        };
    }
}

