<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuditService
{
    /**
     * Log a generic action.
     */
    public function log(
        ?User $user,
        string $action,
        ?string $entityType = null,
        ?int $entityId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): AuditLog {
        return AuditLog::log($user, $action, $entityType, $entityId, $oldValues, $newValues);
    }

    /**
     * Log a model creation.
     */
    public function logCreate(User $user, Model $model, array $values): AuditLog
    {
        return $this->log(
            $user,
            'create',
            get_class($model),
            $model->id,
            null,
            $values
        );
    }

    /**
     * Log a model update.
     */
    public function logUpdate(User $user, Model $model, array $oldValues, array $newValues): AuditLog
    {
        return $this->log(
            $user,
            'update',
            get_class($model),
            $model->id,
            $oldValues,
            $newValues
        );
    }

    /**
     * Log a model deletion.
     */
    public function logDelete(User $user, Model $model): AuditLog
    {
        return $this->log(
            $user,
            'delete',
            get_class($model),
            $model->id,
            $model->toArray(),
            null
        );
    }

    /**
     * Log a user action (login, logout, password change, etc).
     */
    public function logUserAction(User $user, string $action, ?array $details = null): AuditLog
    {
        return $this->log(
            $user,
            $action,
            null,
            null,
            null,
            $details
        );
    }

    /**
     * Get audit logs for a specific model.
     */
    public function getModelLogs(string $entityType, int $entityId): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get audit logs for a specific user.
     */
    public function getUserLogs(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();
    }

    /**
     * Get recent audit logs.
     */
    public function getRecentLogs(int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}

