<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'midtrans_transaction_id',
        'midtrans_order_id',
        'payment_type',
        'status',
        'gross_amount',
        'snap_token',
        'payment_url',
        'expired_at',
        'paid_at',
        'raw_response',
    ];

    protected $casts = [
        'raw_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}