<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasUid;

class Withdrawal extends Model
{
    use HasFactory, HasUid;

    public $timestamps = false;

    protected $fillable = [
        'uid',
        'user_id',
        'amount',
        'method',
        'account_details',
        'status',
        'requested_at',
        'processed_at',
    ];

    protected $dates = ['requested_at', 'processed_at'];

    protected $casts = [
        'account_details' => 'array',
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

