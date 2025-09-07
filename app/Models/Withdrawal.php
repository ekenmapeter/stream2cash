<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'account_details',
        'status',
        'requested_at',
        'processed_at',
    ];

    protected $dates = ['requested_at', 'processed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

