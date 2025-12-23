<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price', // 🔥 harga final (diskon / normal)
    ];

    protected $appends = ['subtotal'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ✅ subtotal pakai harga cart
    public function getSubtotalAttribute()
    {
        if (!$this->price || $this->quantity <= 0) {
            return 0;
        }

        return $this->price * $this->quantity;
    }
}
