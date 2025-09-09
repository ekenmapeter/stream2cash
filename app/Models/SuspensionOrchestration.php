<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuspensionOrchestration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_id',
        'suspension_type',
        'status',
        'reason',
        'cheat_evidence',
        'amount_involved',
        'wallet_credited',
        'email_sent',
        'suspended_at',
        'resolved_at',
        'resolved_by',
        'admin_notes',
        'autopilot_enabled'
    ];

    protected $casts = [
        'cheat_evidence' => 'array',
        'wallet_credited' => 'boolean',
        'email_sent' => 'boolean',
        'suspended_at' => 'datetime',
        'resolved_at' => 'datetime',
        'autopilot_enabled' => 'boolean'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeCheating($query)
    {
        return $query->where('suspension_type', 'cheating');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isAutoApproved()
    {
        return $this->status === 'auto_approved';
    }

    public function isCheating()
    {
        return $this->suspension_type === 'cheating';
    }

    public function approve($adminId = null, $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'resolved_at' => now(),
            'resolved_by' => $adminId,
            'admin_notes' => $notes
        ]);
    }

    public function reject($adminId = null, $notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'resolved_at' => now(),
            'resolved_by' => $adminId,
            'admin_notes' => $notes
        ]);
    }

    public function autoApprove($notes = 'Auto-approved by system')
    {
        $this->update([
            'status' => 'auto_approved',
            'resolved_at' => now(),
            'admin_notes' => $notes
        ]);
    }
}
