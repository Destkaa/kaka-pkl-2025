<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'shopping_cost',
        'status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'payment_method',
        'notes',
    ];
}