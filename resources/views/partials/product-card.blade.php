{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     FUNGSI: Card Produk GADGETPRO (Full Dark Cyber Edition)
     ================================================ --}}

<div class="card product-card h-100 custom-hover">
    {{-- Product Image --}}
    <div class="position-relative overflow-hidden img-container">
        <a href="{{ route('catalog.show', $product->slug) }}" class="no-style">
            <img src="{{ $product->image_url }}" class="card-img-top img-zoom" alt="{{ $product->name }}">
        </a>

        {{-- Badge Diskon --}}
        @if($product->has_discount)
        <span class="badge badge-sale position-absolute top-0 start-0 m-3 shadow-glow">
            <i class="bi bi-lightning-fill me-1"></i> -{{ $product->discount_percentage }}%
        </span>
        @endif

        {{-- Wishlist Button --}}
        @auth
        <button type="button" onclick="toggleWishlist({{ $product->id }})"
                class="btn-wishlist position-absolute top-0 end-0 m-3">
            <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
        </button>
        @endauth
        
        <div class="img-overlay"></div>
    </div>

    {{-- Card Body --}}
    <div class="card-body d-flex flex-column p-4">
        <div class="category-text mb-2 text-uppercase">
            <i class="bi bi-cpu me-1"></i> {{ $product->category->name }}
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
                <span class="currency">Rp</span> {{ number_format($product->price, 0, ',', '.') }}
            </div>
        </div>

        {{-- Stock Info --}}
        <div class="mt-3">
            @if($product->stock <= 5 && $product->stock > 0)
                <div class="stock-badge stock-low">
                    <span class="pulse-dot"></span> SISA {{ $product->stock }} UNIT
                </div>
            @elseif($product->stock == 0)
                <div class="stock-badge stock-out">
                    STOK HABIS
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
            <button type="submit" class="btn btn-add-cart w-100" 
                @if($product->stock == 0) disabled @endif>
                @if($product->stock == 0)
                    STOK KOSONG
                @else
                    <i class="bi bi-cart-plus-fill me-2"></i> TAMBAH KE CART
                @endif
            </button>
        </form>
    </div>
</div>

<style>
    /* --- 1. CORE STYLING (DARK GLASS) --- */
    .product-card {
        border-radius: 24px !important;
        background: rgba(15, 23, 42, 0.4) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(129, 140, 248, 0.1) !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
    }

    .custom-hover:hover {
        transform: translateY(-12px);
        border-color: rgba(129, 140, 248, 0.4) !important;
        box-shadow: 0 15px 35px rgba(129, 140, 248, 0.15) !important;
    }

    /* --- 2. IMAGE SECTION --- */
    .img-container {
        height: 200px;
        background: rgba(2, 6, 23, 0.5);
        position: relative;
    }

    .img-zoom {
        height: 100%;
        width: 100%;
        object-fit: contain;
        padding: 20px;
        transition: all 0.5s ease;
        position: relative;
        z-index: 2;
    }

    .img-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle, rgba(129, 140, 248, 0.05) 0%, transparent 70%);
        z-index: 1;
    }

    .custom-hover:hover .img-zoom {
        transform: scale(1.1);
    }

    /* --- 3. TEXT & PRICING --- */
    .category-text {
        font-size: 0.65rem;
        color: #818cf8 !important;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .product-title a {
        font-size: 1.05rem;
        font-weight: 700;
        color: #ffffff !important;
    }

    .price-current {
        font-size: 1.3rem;
        font-weight: 800;
        color: #ffffff;
    }

    .price-current .currency {
        font-size: 0.8rem;
        color: #818cf8;
    }

    .price-old {
        font-size: 0.85rem;
        color: rgba(165, 180, 252, 0.3);
        text-decoration: line-through;
    }

    /* --- 4. BUTTON GADGETPRO --- */
    .btn-add-cart {
        background: #818cf8 !important;
        color: #020617 !important;
        border: none !important;
        padding: 12px;
        border-radius: 14px;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        transition: 0.3s;
    }

    .btn-add-cart:hover:not(:disabled) {
        background: #ffffff !important;
        box-shadow: 0 0 15px rgba(129, 140, 248, 0.5);
    }

    .btn-add-cart:disabled {
        background: rgba(255, 255, 255, 0.05) !important;
        color: rgba(255, 255, 255, 0.2) !important;
    }

    /* --- 5. EFFECTS --- */
    .badge-sale {
        background: linear-gradient(45deg, #f43f5e, #e11d48);
        border-radius: 10px;
        font-weight: 800;
    }

    .btn-wishlist {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        width: 38px;
        height: 38px;
        border-radius: 12px;
        color: white;
        transition: 0.3s;
    }

    .btn-wishlist:hover {
        background: white;
        color: black;
    }

    .stock-badge {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 8px;
    }
    .stock-low { background: rgba(244, 63, 94, 0.1); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); }
    .stock-out { background: rgba(255, 255, 255, 0.05); color: #64748b; }

    .pulse-dot {
        height: 6px;
        width: 6px;
        background-color: #fb7185;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        animation: pulse-red 1.5s infinite;
    }

    @keyframes pulse-red {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(244, 63, 94, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(244, 63, 94, 0); }
    }
</style>