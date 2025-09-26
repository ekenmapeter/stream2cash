<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Earning extends Model
{
    use HasFactory, HasUid;

    protected $fillable = [
        'uid',
        'user_id',
        'video_id',
        'amount',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function userVideoWatch()
    {
        return $this->hasOne(UserVideoWatch::class, 'video_id', 'video_id')
                    ->where('user_id', $this->user_id);
    }
}

