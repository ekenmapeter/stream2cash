<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserIpRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'device_type',
        'browser',
        'os',
        'is_suspicious',
        'notes',
    ];

    protected $casts = [
        'is_suspicious' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function getLocationAttribute()
    {
        $location = [];
        if ($this->city) $location[] = $this->city;
        if ($this->country) $location[] = $this->country;
        return implode(', ', $location) ?: 'Unknown';
    }

    public function getDeviceInfoAttribute()
    {
        $info = [];
        if ($this->device_type) $info[] = ucfirst($this->device_type);
        if ($this->os) $info[] = $this->os;
        if ($this->browser) $info[] = $this->browser;
        return implode(' - ', $info) ?: 'Unknown';
    }
}
