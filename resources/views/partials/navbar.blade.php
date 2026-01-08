{{-- ================================================
FILE: resources/views/partials/navbar.blade.php
FUNGSI: Navigation bar GADGETPRO (Fix Search Border & Black Outline)
================================================ --}}

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        {{-- Logo & Brand --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div class="rounded-3 d-flex align-items-center justify-content-center me-2 branding-icon" 
                 style="width: 38px; height: 38px; background: #6366f1; color: white;">
                <i class="bi bi-lightning-charge-fill fs-5"></i>
            </div>
            <span class="fw-bold tracking-tight text-dark brand-text">
                GADGET<span style="color: #6366f1;">PRO</span>
            </span>
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Search Form - CLEAN VERSION --}}
            <form class="d-flex mx-auto mt-3 mt-lg-0 mb-3 mb-lg-0 position-relative search-container" action="{{ route('catalog.index') }}" method="GET">
                <div class="search-wrapper shadow-sm">
                    <i class="bi bi-search search-icon-left"></i>
                    <input type="text" name="q" 
                           class="search-input shadow-none" 
                           placeholder="Cari seri iPhone, Laptop Pro..." 
                           value="{{ request('q') }}"
                           autocomplete="off">
                    <button class="search-button-premium" type="submit">Cari Produk</button>
                </div>
            </form>

            {{-- Right Menu --}}
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link fw-semibold d-flex align-items-center link-custom" href="{{ route('catalog.index') }}">
                        <i class="bi bi-grid-fill me-2"></i> Katalog
                    </a>
                </li>

                @auth
                <div class="d-flex align-items-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link position-relative px-2" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart fs-5 text-dark"></i>
                            @php $wishlistCount = auth()->user()->wishlists()->count(); @endphp
                            <span class="badge-custom {{ $wishlistCount > 0 ? '' : 'd-none' }}">{{ $wishlistCount }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative px-2" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5 text-dark"></i>
                            @php $cartCount = auth()->user()->cart?->items()->count() ?? 0; @endphp
                            @if($cartCount > 0)
                            <span class="badge-custom" style="background-color: #6366f1;">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                </div>

                <li class="nav-item dropdown ms-lg-2">
                    <a class="nav-link dropdown-toggle p-0 shadow-none border-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar-trigger-box d-flex align-items-center bg-white rounded-pill px-2 py-1 border shadow-sm">
                            <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle me-1" width="28" height="28" style="object-fit: cover;">
                            <i class="bi bi-chevron-down small text-muted ms-1" style="font-size: 0.7rem;"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3 py-3 px-2 custom-dropdown-animate" aria-labelledby="userDropdown">
                        <li class="px-3 py-3 mb-2 bg-light rounded-4 mx-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-indigo rounded-circle me-3 d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 40px; height: 40px; background: #6366f1;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="overflow-hidden">
                                    <h6 class="mb-0 fw-bold text-dark text-truncate" style="font-size: 0.9rem;">{{ auth()->user()->name }}</h6>
                                    <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">{{ auth()->user()->email }}</small>
                                </div>
                            </div>
                        </li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2 text-indigo"></i> Profil</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('orders.index') }}"><i class="bi bi-box-seam me-2 text-indigo"></i> Pesanan</a></li>
                        @if(auth()->user()->isAdmin())
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li><a class="dropdown-item rounded-3 py-2 fw-bold text-indigo" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Admin Panel</a></li>
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
                <li class="nav-item"><a class="nav-link text-dark fw-bold px-3" href="{{ route('login') }}">Masuk</a></li>
                <li class="nav-item"><a class="btn btn-indigo-premium rounded-pill px-4 shadow-sm text-white" href="{{ route('register') }}">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .text-indigo { color: #6366f1 !important; }
    .bg-indigo { background-color: #6366f1 !important; }
    .brand-text { letter-spacing: -1px; font-size: 1.25rem; }

    /* --- SEARCH FIX (NO BLACK BORDER) --- */
    .search-container { max-width: 550px; width: 100%; transition: all 0.3s ease; }
    
    .search-wrapper {
        display: flex; align-items: center; background: #f1f5f9;
        border-radius: 100px; padding: 4px 6px 4px 18px; width: 100%;
        border: 2px solid transparent !important; /* Paksa transparan */
        transition: all 0.3s ease;
        outline: none !important;
    }

    .search-input { 
        flex: 1; 
        background: transparent !important; 
        border: none !important; 
        padding: 8px 10px; 
        font-size: 0.95rem; 
        outline: none !important; /* Hapus garis hitam */
        box-shadow: none !important; /* Hapus glow biru default */
    }

    /* Hilangkan border hitam saat diklik */
    .search-input:focus, .search-input:active {
        outline: none !important;
        border: none !important;
        box-shadow: none !important;
    }

    .search-button-premium {
        background: #1e293b; color: white; border: none; border-radius: 100px;
        padding: 8px 20px; font-weight: 600; font-size: 0.85rem; transition: 0.3s;
    }

    .search-wrapper:focus-within {
        background: white; 
        border: 2px solid #6366f1 !important; /* Munculkan border ungu saja */
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.2) !important;
    }
    
    .search-wrapper:focus-within .search-button-premium { background: #6366f1; }

    /* --- DROPDOWN DESIGN --- */
    .dropdown-toggle::after { display: none !important; }
    .avatar-trigger-box { transition: all 0.2s; cursor: pointer; }
    .avatar-trigger-box:hover { border-color: #6366f1 !important; transform: translateY(-1px); }

    .custom-dropdown-animate {
        opacity: 0; visibility: hidden; transform: translateY(15px);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: block !important;
    }

    .dropdown-menu.show.custom-dropdown-animate { opacity: 1; visibility: visible; transform: translateY(0); }
    
    /* --- UTILS --- */
    .badge-custom {
        position: absolute; top: 2px; left: 22px; padding: 3px 6px;
        font-size: 0.65rem; font-weight: 800; border-radius: 50%;
        background-color: #ef4444; color: white; border: 2px solid white;
    }
    .btn-indigo-premium { background: #6366f1; font-weight: 700; transition: 0.3s; }
    .btn-indigo-premium:hover { background: #4f46e5; transform: translateY(-1px); }
</style>