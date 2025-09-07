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
}

