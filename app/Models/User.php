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
     *
     * @var array<int, string>
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
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
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
     * Menangani file lokal, URL eksternal (Google), dan fallback inisial.
     */
    public function getAvatarUrlAttribute(): string
    {
        $avatarPath = trim($this->avatar ?? '');

        // 1. Jika avatar adalah URL eksternal lengkap (misal: Login Google)
        if (filter_var($avatarPath, FILTER_VALIDATE_URL)) {
            return $avatarPath;
        }

        // 2. Jika avatar adalah path file lokal (misal: 'avatars/gambar.jpg')
        if ($avatarPath) {
            // Pastikan file benar-benar ada di folder storage/app/public
            if (Storage::disk('public')->exists($avatarPath)) {
                return Storage::disk('public')->url($avatarPath);
            }
        }

        // 3. Fallback: Gunakan UI Avatars jika tidak ada foto
        // Ini akan menampilkan inisial nama user (misal: "JD" untuk John Doe)
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