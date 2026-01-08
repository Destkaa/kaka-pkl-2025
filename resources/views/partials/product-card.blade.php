{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     FUNGSI: Card Produk GADGETPRO (Fix Dark Mode & No Purple Shadow)
     ================================================ --}}

<div class="card product-card h-100 border-0 shadow-sm custom-hover">
    {{-- Product Image --}}
    <div class="position-relative overflow-hidden img-container">
        <a href="{{ route('catalog.show', $product->slug) }}" class="no-style">
            <img src="{{ $product->image_url }}" class="card-img-top img-zoom" alt="{{ $product->name }}">
        </a>

        {{-- Badge Diskon --}}
        @if($product->has_discount)
        <span class="badge badge-sale position-absolute top-0 start-0 m-3 shadow-sm">
            <i class="bi bi-tag-fill me-1"></i> -{{ $product->discount_percentage }}%
        </span>
        @endif

        {{-- Wishlist Button --}}
        @auth
        <button type="button" onclick="toggleWishlist({{ $product->id }})"
                class="btn-wishlist shadow-sm position-absolute top-0 end-0 m-3">
            <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
        </button>
        @endauth
    </div>

    {{-- Card Body --}}
    <div class="card-body d-flex flex-column p-4">
        <div class="category-text mb-2 text-uppercase tracking-wider">
            {{ $product->category->name }}
        </div>

        <h6 class="product-title mb-3">
            <a href="{{ route('catalog.show', $product->slug) }}" class="stretched-link">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        <div class="mt-auto">
            @if($product->has_discount)
            <div class="price-old mb-1">
                {{ $product->formatted_original_price }}
            </div>
            @endif
            <div class="price-current">
                {{ $product->formatted_price }}
            </div>
        </div>

        {{-- Stock Info --}}
        <div class="mt-3">
            @if($product->stock <= 5 && $product->stock > 0)
                <div class="stock-badge stock-low">
                    <i class="bi bi-fire me-1"></i> Sisa {{ $product->stock }} lagi!
                </div>
            @elseif($product->stock == 0)
                <div class="stock-badge stock-out">
                    <i class="bi bi-slash-circle me-1"></i> Habis
                </div>
            @endif
        </div>
    </div>

    {{-- Card Footer --}}
    <div class="card-footer bg-transparent border-0 p-4 pt-0">
        <form action="{{ route('cart.add') }}" method="POST" class="position-relative" style="z-index: 3;">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-add-cart w-100 fw-bold" 
                @if($product->stock == 0) disabled @endif>
                @if($product->stock == 0)
                    SUDAH TERJUAL
                @else
                    <i class="bi bi-cart-plus me-2"></i> TAMBAH
                @endif
            </button>
        </form>
    </div>
</div>

<style>
    /* --- 1. RESET & GHOSTING FIX (MENGHILANGKAN UNGU/BIRU) --- */
    .product-card, 
    .product-card a, 
    .product-card button,
    .product-card form {
        -webkit-tap-highlight-color: transparent !important;
        outline: none !important;
        text-decoration: none !important;
    }

    .product-card a:focus, 
    .product-card button:focus {
        box-shadow: none !important;
        outline: none !important;
    }

    /* --- 2. CARD CORE STYLING (DARK MODE COMPATIBLE) --- */
    .product-card {
        border-radius: 20px !important;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
        background: var(--bg-card) !important;
        border: 1px solid var(--border-color) !important;
    }

    .custom-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
    }

    /* --- 3. IMAGE SECTION --- */
    .img-container {
        border-radius: 20px 20px 0 0;
        height: 220px;
        background: #f8fafc; /* Placeholder warna sebelum gambar muat */
    }

    .img-zoom {
        height: 100%;
        width: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .custom-hover:hover .img-zoom {
        transform: scale(1.1);
    }

    /* --- 4. BADGES & BUTTONS --- */
    .badge-sale {
        background: #ef4444;
        color: white;
        padding: 8px 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.7rem;
        z-index: 2;
    }

    .btn-wishlist {
        border: none;
        background: var(--bg-card) !important;
        color: var(--text-main) !important;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 5;
        transition: 0.2s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }

    .btn-wishlist:hover { transform: scale(1.15); }

    /* --- 5. TEXT & PRICING --- */
    .category-text {
        font-size: 0.65rem;
        color: var(--text-light);
        font-weight: 700;
        letter-spacing: 1.5px;
    }

    .product-title a {
        font-size: 0.95rem;
        line-height: 1.4;
        font-weight: 700;
        color: var(--text-main) !important;
        transition: color 0.2s;
    }

    .product-title a:hover { color: var(--primary-color) !important; }

    .price-old {
        font-size: 0.8rem;
        color: var(--text-light);
        text-decoration: line-through;
    }

    .price-current {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-main);
    }

    /* --- 6. STOCK STATUS --- */
    .stock-badge {
        font-size: 0.7rem;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        display: inline-block;
    }

    .stock-low { background: #fff9db; color: #f08c00; }
    .stock-out { background: #f1f2f6; color: #747d8c; }

    [data-bs-theme="dark"] .stock-low { background: rgba(240, 140, 0, 0.15); color: #ffd43b; }
    [data-bs-theme="dark"] .stock-out { background: rgba(255, 255, 255, 0.05); color: #94a3b8; }

    /* --- 7. BUTTON ADD TO CART (FIX UNGU) --- */
    .btn-add-cart {
        background: var(--primary-color) !important;
        color: white !important;
        border: none !important;
        padding: 12px;
        border-radius: 14px;
        font-size: 0.8rem;
        transition: all 0.3s;
        box-shadow: none !important;
    }

    .btn-add-cart:hover:not(:disabled) {
        filter: brightness(1.1);
        transform: translateY(-2px);
    }

    .btn-add-cart:active {
        transform: scale(0.95);
        filter: brightness(0.9);
    }

    .btn-add-cart:disabled {
        background: var(--border-color) !important;
        color: var(--text-light) !important;
        cursor: not-allowed;
    }
</style>