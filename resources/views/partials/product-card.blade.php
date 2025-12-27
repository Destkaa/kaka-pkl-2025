{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     FUNGSI: Komponen kartu produk dengan gaya Modern & Clean
     ================================================ --}}

<div class="card product-card h-100 border-0 shadow-sm transition-hover">
    {{-- Product Image --}}
    <div class="position-relative overflow-hidden" style="border-radius: 20px 20px 0 0;">
        <a href="{{ route('catalog.show', $product->slug) }}">
            <img src="{{ $product->image_url }}" class="card-img-top img-zoom" alt="{{ $product->name }}"
                style="height: 220px; object-fit: cover;">
        </a>

        {{-- Badge Diskon --}}
        @if($product->has_discount)
        <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm fw-bold" style="z-index: 2;">
            <i class="bi bi-tag-fill me-1"></i> -{{ $product->discount_percentage }}%
        </span>
        @endif

        {{-- Wishlist Button --}}
        @auth
        <button type="button" onclick="toggleWishlist({{ $product->id }})"
            class="btn btn-white shadow-sm position-absolute top-0 end-0 m-3 rounded-circle d-flex align-items-center justify-content-center p-0"
            style="width: 35px; height: 35px; z-index: 2;">
            <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }} fs-6"></i>
        </button>
        @endauth
    </div>

    {{-- Card Body --}}
    <div class="card-body d-flex flex-column p-4">
        {{-- Category --}}
        <div class="mb-2 text-uppercase tracking-wider small text-muted fw-semibold">
            {{ $product->category->name }}
        </div>

        {{-- Product Name --}}
        <h6 class="card-title mb-3 fs-6 lh-base">
            <a href="{{ route('catalog.show', $product->slug) }}" class="text-decoration-none text-dark fw-bold stretched-link">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        {{-- Price --}}
        <div class="mt-auto">
            @if($product->has_discount)
            <div class="d-flex align-items-center gap-2 mb-1">
                <small class="text-muted text-decoration-line-through">
                    {{ $product->formatted_original_price }}
                </small>
            </div>
            @endif
            <div class="fs-5 fw-black text-primary">
                {{ $product->formatted_price }}
            </div>
        </div>

        {{-- Stock Info --}}
        <div class="mt-3">
            @if($product->stock <= 5 && $product->stock > 0)
                <div class="p-2 rounded-3 bg-warning-subtle text-warning-emphasis small border border-warning-subtle">
                    <i class="bi bi-fire me-1"></i> Sisa {{ $product->stock }} lagi!
                </div>
            @elseif($product->stock == 0)
                <div class="p-2 rounded-3 bg-secondary-subtle text-secondary small border border-secondary-subtle">
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
            <button type="submit" class="btn btn-primary btn-pill w-100 py-2 fw-bold d-flex align-items-center justify-content-center gap-2" 
                @if($product->stock == 0) disabled @endif>
                @if($product->stock == 0)
                    Sudah Terjual
                @else
                    <i class="bi bi-cart-plus fs-5"></i> Tambah
                @endif
            </button>
        </form>
    </div>
</div>