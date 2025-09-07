<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'thumbnail',
        'reward_per_view',
        'status',
    ];

    public function watches()
    {
        return $this->hasMany(UserVideoWatch::class);
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }
}

