<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasUid;

class Video extends Model
{
    use HasFactory, HasUid;

    protected $fillable = [
        'uid',
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

