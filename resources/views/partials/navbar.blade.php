{{-- ================================================
FILE: resources/views/partials/navbar.blade.php
FUNGSI: Navigation bar dengan Branding GADGETPRO (Senada dengan Admin)
================================================ --}}

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        {{-- Logo & Brand (Disamakan dengan Admin) --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div class="rounded-3 d-flex align-items-center justify-content-center me-2" 
                 style="width: 35px; height: 35px; background: #6366f1; color: white;">
                <i class="bi bi-lightning-charge-fill fs-5"></i>
            </div>
            <span class="fw-bold tracking-tight text-dark" style="letter-spacing: -0.5px;">
                GADGET<span style="color: #6366f1;">PRO</span>
            </span>
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar Content --}}
        <div class="collapse navbar-collapse" id="navbarMain">
            
            {{-- Search Form --}}
            <form class="d-flex mx-auto mt-3 mt-lg-0 mb-3 mb-lg-0 position-relative" style="max-width: 400px; width: 100%;" action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group search-group rounded-pill overflow-hidden border-0 bg-light">
                    <span class="input-group-text bg-transparent border-0 ps-3">
                        <i class="bi bi-search text-muted small"></i>
                    </span>
                    <input type="text" name="q" 
                        class="form-control bg-transparent border-0 py-2 shadow-none small" 
                        placeholder="Cari Produk..." 
                        value="{{ request('q') }}"
                        style="font-size: 0.9rem;">
                </div>
            </form>

            {{-- Right Menu --}}
            <ul class="navbar-nav ms-auto align-items-center">
                {{-- Katalog --}}
                <li class="nav-item">
                    <a class="nav-link fw-semibold mx-lg-2 d-flex align-items-center link-custom" href="{{ route('catalog.index') }}">
                        <i class="bi bi-grid-fill me-2"></i>
                        <span>Katalog</span>
                    </a>
                </li>

                @auth
                {{-- Wishlist --}}
                <li class="nav-item">
                    <a class="nav-link position-relative px-2 mx-lg-1" href="{{ route('wishlist.index') }}">
                        <i class="bi bi-heart fs-5 text-dark"></i>
                        @php $wishlistCount = auth()->user()->wishlists()->count(); @endphp
                        <span id="wishlist-count" 
                            class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.6rem; {{ $wishlistCount > 0 ? '' : 'display: none;' }}">
                            {{ $wishlistCount }}
                        </span>
                    </a>
                </li>

                {{-- Cart --}}
                <li class="nav-item">
                    <a class="nav-link position-relative px-2 mx-lg-1" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart3 fs-5 text-dark"></i>
                        @php $cartCount = auth()->user()->cart?->items()->count() ?? 0; @endphp
                        @if($cartCount > 0)
                        <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-indigo"
                            style="font-size: 0.6rem; background-color: #6366f1;">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </a>
                </li>

                {{-- User Dropdown --}}
                <li class="nav-item dropdown ms-lg-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center p-0 mt-2 mt-lg-0" href="#" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="avatar-trigger d-flex align-items-center bg-white rounded-pill px-2 py-1 border shadow-sm">
                            <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle me-2" width="28" height="28" style="object-fit: cover;">
                            <i class="bi bi-chevron-down small text-muted"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3 py-3 px-2" style="min-width: 260px;">
                        <li class="px-3 py-3 mb-2 bg-light rounded-4 mx-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-indigo rounded-circle me-3 d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 40px; height: 40px; background: #6366f1;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="overflow-hidden">
                                    <h6 class="mb-0 fw-bold text-dark text-truncate">{{ auth()->user()->name }}</h6>
                                    <small class="text-muted d-block text-truncate">{{ auth()->user()->email }}</small>
                                </div>
                            </div>
                        </li>
                        
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person me-2 text-indigo"></i> Profil Saya
                        </a></li>

                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('orders.index') }}">
                            <i class="bi bi-box-seam me-2 text-indigo"></i> Pesanan Saya
                        </a></li>

                        @if(auth()->user()->isAdmin())
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li><a class="dropdown-item rounded-3 py-2 fw-bold text-indigo" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                        </a></li>
                        @endif

                        <li><hr class="dropdown-divider opacity-50"></li>
                        
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-3 py-2 text-danger fw-semibold">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold px-3" href="{{ route('login') }}">Masuk</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-indigo rounded-pill px-4 btn-sm fw-bold shadow-sm text-white" 
                       style="background-color: #6366f1;" href="{{ route('register') }}">Daftar</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .text-indigo { color: #6366f1 !important; }
    .bg-indigo { background-color: #6366f1 !important; }
    
    /* Search Styling */
    .search-group { background-color: #f1f5f9 !important; transition: all 0.2s; border: 1px solid transparent !important; }
    .search-group:focus-within { background-color: #fff !important; border-color: #6366f1 !important; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1) !important; }

    /* Nav Link Styling */
    .link-custom { color: #475569 !important; transition: all 0.2s; }
    .link-custom:hover { color: #6366f1 !important; }
    .link-custom i { transition: transform 0.3s; }
    .link-custom:hover i { transform: rotate(15deg) scale(1.1); }

    /* Dropdown Animation */
    .dropdown-menu {
        display: block;
        visibility: hidden;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.2s ease-in-out;
    }
    .dropdown-menu.show {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }
    .dropdown-item:hover {
        background-color: #f8fafc;
        color: #6366f1;
        padding-left: 1.25rem !important;
    }
    .dropdown-toggle::after { display: none; }
</style>