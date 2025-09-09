<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserVideoWatch extends Model
{
    use HasFactory;

    public $timestamps = false; // we only store watched_at
    protected $fillable = [
        'user_id',
        'video_id',
        'watched_at',
        'reward_earned',
        'watch_duration',
        'video_duration',
        'watch_percentage',
        'seek_count',
        'pause_count',
        'heartbeat_count',
        'tab_visible',
        'watch_events',
        'is_valid',
        'validation_notes',
    ];

    protected $casts = [
        'watched_at' => 'datetime',
        'watch_events' => 'array',
        'is_valid' => 'boolean',
        'tab_visible' => 'boolean',
    ];

    protected $dates = ['watched_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function earning()
    {
        return $this->hasOne(Earning::class, 'video_id', 'video_id')
                    ->where('user_id', $this->user_id);
    }
}

