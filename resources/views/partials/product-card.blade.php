{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     FUNGSI: Card Produk GADGETPRO (Premium Black & Purple Accent)
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
            <a href="{{ route('catalog.show', $product->slug) }}" class="stretched-link text-decoration-none">
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
    /* --- 1. RESET & CORE STYLING --- */
    .product-card {
        border-radius: 24px !important;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        background: #ffffff !important;
        border: 1px solid rgba(0,0,0,0.05) !important;
        overflow: hidden;
    }

    .custom-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    /* --- 2. IMAGE SECTION --- */
    .img-container {
        height: 220px;
        background: #f8fafc;
    }

    .img-zoom {
        height: 100%;
        width: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .custom-hover:hover .img-zoom {
        transform: scale(1.08);
    }

    /* --- 3. TEXT & PRICING --- */
    .category-text {
        font-size: 0.65rem;
        color: #94a3b8;
        font-weight: 700;
        letter-spacing: 1.2px;
    }

    .product-title a {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1625 !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .price-current {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1a1625;
    }

    .price-old {
        font-size: 0.85rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    /* --- 4. BUTTON TAMBAH (BLACK & PURPLE ACCENT) --- */
    .btn-add-cart {
        background: #1a1625 !important; /* Hitam Dasar */
        color: #ffffff !important;
        border: 1px solid rgba(99, 102, 241, 0.2) !important; /* Aksen Ungu Halus */
        padding: 12px;
        border-radius: 14px;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
    }

    .btn-add-cart i {
        color: #818cf8; /* Ikon Ungu GadgetPro */
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover:not(:disabled) {
        background: #2d263f !important; /* Hitam agak ungu saat hover */
        border-color: #6366f1 !important; /* Border Ungu Nyala */
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.2) !important; /* Glow Ungu */
        transform: translateY(-2px);
    }

    .btn-add-cart:hover i {
        color: #ffffff; /* Ikon jadi putih saat hover */
        transform: rotate(-10deg);
    }

    .btn-add-cart:active {
        transform: scale(0.96);
    }

    .btn-add-cart:disabled {
        background: #e2e8f0 !important;
        color: #94a3b8 !important;
        border: none !important;
        cursor: not-allowed;
    }

    /* --- 5. OTHER ELEMENTS --- */
    .badge-sale {
        background: #ef4444;
        border-radius: 50px;
        font-size: 0.7rem;
        padding: 6px 12px;
    }

    .btn-wishlist {
        background: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
        z-index: 10;
    }

    .btn-wishlist:hover {
        transform: scale(1.1);
        background: #f5f3ff;
    }

    .stock-badge {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
    }
    .stock-low { background: #fff1f2; color: #e11d48; }
    .stock-out { background: #f1f5f9; color: #64748b; }

    /* Dark Mode Support */
    [data-bs-theme="dark"] .product-card {
        background: #1a1625 !important;
        border-color: rgba(255,255,255,0.05) !important;
    }
    [data-bs-theme="dark"] .product-title a,
    [data-bs-theme="dark"] .price-current {
        color: #ffffff !important;
    }
</style>