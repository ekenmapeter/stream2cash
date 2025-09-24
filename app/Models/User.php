<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lab404\Impersonate\Models\Impersonate;
use App\Models\Referral;
use Illuminate\Support\Str;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, Impersonate;

    protected $fillable = [
        'uid',
        'name',
        'email',
        'password',
        'balance',
        'role',
        'status',
        'suspended_at',
        'blocked_at',
        'suspension_reason',
        'block_reason',
        'payout_method',
        'bank_name',
        'account_name',
        'account_number',
        'paypal_email',
        'payout_meta',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'suspended_at' => 'datetime',
        'blocked_at' => 'datetime',
        'payout_meta' => 'array',
        'last_login_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uid)) {
                $model->uid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uid';
    }

    // Relationships
    public function watches()
    {
        return $this->hasMany(UserVideoWatch::class);
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function referralsMade()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referredBy()
    {
        return $this->hasOne(Referral::class, 'referee_id');
    }

    public function ipRecords()
    {
        return $this->hasMany(UserIpRecord::class);
    }

    public function suspensionOrchestrations()
    {
        return $this->hasMany(SuspensionOrchestration::class);
    }

    public function pendingSuspensions()
    {
        return $this->suspensionOrchestrations()->pending();
    }

    // Status helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isSuspended()
    {
        return $this->status === 'suspended';
    }

    public function isBlocked()
    {
        return $this->status === 'blocked';
    }

    public function canAccess()
    {
        return $this->isActive();
    }

    // Status management methods
    public function suspend($reason = null)
    {
        $this->update([
            'status' => 'suspended',
            'suspended_at' => now(),
            'suspension_reason' => $reason,
        ]);
    }

    public function block($reason = null)
    {
        $this->update([
            'status' => 'blocked',
            'blocked_at' => now(),
            'block_reason' => $reason,
        ]);
    }

    public function activate()
    {
        $this->update([
            'status' => 'active',
            'suspended_at' => null,
            'blocked_at' => null,
            'suspension_reason' => null,
            'block_reason' => null,
        ]);
    }

    /**
     * Check if user can be impersonated
     */
    public function canBeImpersonated()
    {
        // Only allow impersonating users (not admins)
        return $this->role === 'user' && $this->isActive();
    }

    /**
     * Check if user can impersonate others
     */
    public function canImpersonate()
    {
        // Only admins can impersonate
        return $this->role === 'admin';
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}

