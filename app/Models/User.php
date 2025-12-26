<?php
// app/Models/User.php

namespace App\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// PERBAIKAN: Gunakan Facade Storage yang benar agar fungsi Storage::disk() bisa terbaca
use Illuminate\Support\Facades\Storage; 

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     */
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

    /**
     * Kolom yang disembunyikan saat serialisasi ke JSON/array.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data otomatis.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wishlists()
    {
        return $this->belongsToMany(Product::class, 'wishlists')
            ->withTimestamps();
    }

    // ==================== HELPER METHODS ====================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function hasInWishlist(Product $product): bool
    {
        return $this->wishlists()
            ->where('product_id', $product->id)
            ->exists();
    }

    public function getAvatarUrlAttribute(): string
    {
        // Menggunakan Storage Facade yang sudah diimport dengan benar di atas
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
        $words    = explode(' ', $this->name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return substr($initials, 0, 2);
    }
}