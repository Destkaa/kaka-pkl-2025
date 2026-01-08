@props(['product'])

<div class="card h-100 border-0 shadow-sm product-card custom-hover">
    {{-- Gambar Produk --}}
    <div class="position-relative overflow-hidden bg-light img-container" style="padding-top: 100%;">
        <a href="{{ route('catalog.show', $product->slug) }}">
            <img src="{{ $product->image_url }}"
                class="card-img-top position-absolute top-0 start-0 w-100 h-100 object-fit-cover img-zoom" 
                alt="{{ $product->name }}">
        </a>

        {{-- Badge Diskon --}}
        @if($product->has_discount)
        <span class="position-absolute top-0 start-0 m-3 badge badge-sale shadow-sm">
            <i class="bi bi-tag-fill me-1"></i> -{{ $product->discount_percentage }}%
        </span>
        @endif

        {{-- Wishlist Button --}}
        <button onclick="toggleWishlist({{ $product->id }})"
            class="wishlist-btn-{{ $product->id }} btn btn-wishlist shadow-sm position-absolute top-0 end-0 m-3">
            <i class="bi {{ Auth::check() && Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }} fs-5"></i>
        </button>
    </div>

    {{-- Info Produk --}}
    <div class="card-body d-flex flex-column p-4">
        <small class="category-text mb-1 text-uppercase">{{ $product->category->name }}</small>
        <h6 class="product-title mb-3">
            <a href="{{ route('catalog.show', $product->slug) }}" class="text-decoration-none text-dark stretched-link">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        <div class="mt-auto">
            @if($product->has_discount)
                <div class="price-current">{{ $product->formatted_price }}</div>
                <div class="price-old">{{ $product->formatted_original_price }}</div>
            @else
                <div class="price-current">{{ $product->formatted_price }}</div>
            @endif
        </div>

        {{-- Stok Status --}}
        <div class="mt-3">
            @if($product->stock <= 5 && $product->stock > 0)
                <div class="stock-badge stock-low">⚡ Sisa {{ $product->stock }} lagi!</div>
            @elseif($product->stock == 0)
                <div class="stock-badge stock-out">Habis Terjual</div>
            @endif
        </div>
    </div>

    {{-- Tombol Tambah Keranjang (Hitam & Ungu) --}}
    <div class="card-footer bg-transparent border-0 p-4 pt-0">
        <form action="{{ route('cart.add') }}" method="POST" class="position-relative" style="z-index: 3;">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-add-cart w-100 fw-bold" 
                @if($product->stock == 0) disabled @endif>
                @if($product->stock == 0)
                    STOK HABIS
                @else
                    <i class="bi bi-cart-plus me-2"></i> TAMBAH
                @endif
            </button>
        </form>
    </div>
</div>

<style>
    /* 1. Card Core */
    .product-card {
        border-radius: 24px !important;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        background: #ffffff;
    }

    .custom-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    /* 2. Gambar & Zoom */
    .img-container {
        border-radius: 24px 24px 0 0;
    }

    .img-zoom {
        transition: transform 0.5s ease;
    }

    .custom-hover:hover .img-zoom {
        transform: scale(1.08);
    }

    /* 3. Typography */
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
        line-height: 1.4;
    }

    .price-current {
        font-size: 1.2rem;
        font-weight: 800;
        color: #1a1625;
    }

    .price-old {
        font-size: 0.85rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    /* 4. TOMBOL TAMBAH KERANJANG (Hitam & Aksen Ungu) */
    .btn-add-cart {
        background: #1a1625 !important; /* Hitam Dasar */
        color: #ffffff !important;
        border: 1px solid rgba(99, 102, 241, 0.2) !important; /* Aksen Ungu */
        padding: 12px;
        border-radius: 14px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .btn-add-cart i {
        color: #818cf8; /* Ikon Ungu */
    }

    .btn-add-cart:hover:not(:disabled) {
        background: #2d263f !important;
        border-color: #6366f1 !important;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.2) !important;
        transform: translateY(-2px);
    }

    .btn-add-cart:hover i {
        color: #ffffff;
    }

    /* 5. Wishlist & Badges */
    .btn-wishlist {
        background: white !important;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: 0.2s;
    }

    .btn-wishlist:hover { transform: scale(1.1); }

    .badge-sale {
        background: #ef4444;
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 700;
    }

    .stock-badge {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 8px;
        display: inline-block;
    }
    .stock-low { background: #fff1f2; color: #e11d48; }
    .stock-out { background: #f1f5f9; color: #64748b; }
</style>