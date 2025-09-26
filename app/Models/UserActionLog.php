<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActionLog extends Model
{
    protected $fillable = [
        'admin_id',
        'target_user_id',
        'action',
        'description',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public static function logAction(
        int $adminId,
        int $targetUserId,
        string $action,
        string $description,
        array $oldData = null,
        array $newData = null,
        string $ipAddress = null,
        string $userAgent = null
    ): self {
        return self::create([
            'admin_id' => $adminId,
            'target_user_id' => $targetUserId,
            'action' => $action,
            'description' => $description,
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }
}
