<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'google_id',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ================= RELATIONSHIPS =================

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * RELASI UTAMA WISHLIST
     * Pivot table: wishlists (user_id, product_id)
     */
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists')
                    ->withTimestamps();
    }

    /**
     * ALIAS — supaya kode lama TIDAK ERROR
     * (Controller / Blade kamu masih pakai wishlists())
     */
    public function wishlists()
    {
        return $this->wishlist();
    }

    /**
     * ALIAS — kalau ada yang pakai wishlistProducts()
     */
    public function wishlistProducts()
    {
        return $this->wishlist();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ================= HELPERS =================

    public function hasInWishlist(Product $product): bool
    {
        return $this->wishlist()
                    ->where('product_id', $product->id)
                    ->exists();
    }

    // ================= ACCESSORS =================

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        if (str_starts_with($this->avatar ?? '', 'http')) {
            return $this->avatar;
        }

        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return substr($initials, 0, 2);
    }
}
