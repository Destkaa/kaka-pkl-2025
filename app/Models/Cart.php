<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
    ];

    /**
     * Cart milik user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Item-item di dalam cart
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
