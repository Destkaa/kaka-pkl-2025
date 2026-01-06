<?php

namespace App\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage; 

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Perbaikan Keamanan: Menghapus 'role' dari fillable untuk mencegah 
     * Mass Assignment Attack (user mengubah dirinya jadi admin).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // 'role', // Dihapus demi keamanan
        'avatar',
        'google_id',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
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

    /**
     * Aksesor untuk mendapatkan URL Avatar yang valid.
     */
    public function getAvatarUrlAttribute(): string
    {
        $avatarPath = trim($this->avatar ?? '');

        // 1. Jika avatar adalah URL eksternal lengkap (misal: Login Google)
        if (filter_var($avatarPath, FILTER_VALIDATE_URL)) {
            return $avatarPath;
        }

        // 2. Jika avatar adalah path file lokal
        if ($avatarPath) {
            if (Storage::disk('public')->exists($avatarPath)) {
                return Storage::disk('public')->url($avatarPath);
            }
        }

        // 3. Fallback: UI Avatars
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&color=7F9CF5&background=EBF4FF";
    }

    /**
     * Mendapatkan inisial nama (maksimal 2 karakter).
     */
    public function getInitialsAttribute(): string
    {
        $words    = explode(' ', $this->name);
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }

        return substr($initials, 0, 2);
    }
}