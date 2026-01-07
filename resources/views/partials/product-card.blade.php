{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
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
    <div class="card-footer bg-white border-0 p-4 pt-0">
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
    /* Reset Link & Focus (MENGHILANGKAN GARIS BIRU) */
    .product-card a {
        text-decoration: none !important; /* Hapus underline */
        color: inherit !important;      /* Hapus warna biru link */
        outline: none !important;       /* Hapus outline saat diklik */
        box-shadow: none !important;    /* Hapus shadow fokus */
    }

    .product-card button:focus, 
    .product-card .btn:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    /* Card Styling */
    .product-card {
        border-radius: 20px !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #fff;
    }

    .custom-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    /* Image Styling */
    .img-container {
        border-radius: 20px 20px 0 0;
        height: 220px;
    }

    .img-zoom {
        height: 100%;
        width: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .custom-hover:hover .img-zoom {
        transform: scale(1.1);
    }

    /* Badges */
    .badge-sale {
        background: #ff4757;
        color: white;
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
    }

    .btn-wishlist {
        border: none;
        background: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        transition: all 0.2s;
    }

    .btn-wishlist:hover {
        transform: scale(1.1);
    }

    /* Typography */
    .category-text {
        font-size: 0.7rem;
        color: #a4b0be;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .product-title {
        font-size: 0.95rem;
        line-height: 1.4;
        font-weight: 700;
        color: #2f3542;
    }

    .price-old {
        font-size: 0.8rem;
        color: #a4b0be;
        text-decoration: line-through;
    }

    .price-current {
        font-size: 1.25rem;
        font-weight: 800;
        color: #2f3542;
    }

    /* Stock Status */
    .stock-badge {
        font-size: 0.75rem;
        padding: 8px 12px;
        border-radius: 10px;
        font-weight: 600;
    }

    .stock-low {
        background: #fff9db;
        color: #f08c00;
    }

    .stock-out {
        background: #f1f2f6;
        color: #747d8c;
    }

    /* Button Add To Cart */
    .btn-add-cart {
        background: #2f3542; /* Warna Gelap Modern */
        color: white;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-size: 0.85rem;
        transition: all 0.3s;
    }

    .btn-add-cart:hover:not(:disabled) {
        background: #000;
        transform: scale(1.02);
        color: white;
    }

    .btn-add-cart:disabled {
        background: #dfe4ea;
        color: #a4b0be;
        cursor: not-allowed;
    }
</style>