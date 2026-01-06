<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3a5f 0%, #0f172a 100%);
            position: sticky; top: 0; z-index: 1000;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 12px;
            transition: all 0.2s;
            display: flex; align-items: center;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .nav-section-title {
            font-size: 0.65rem;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,0.4);
            padding: 15px 25px 5px;
            text-transform: uppercase;
        }
        /* Style Tambahan untuk Tombol Lihat Toko */
        .btn-view-store {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            font-size: 0.85rem;
            transition: all 0.3s;
        }
        .btn-view-store:hover {
            background: #fff;
            color: #1e3a5f;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar d-flex flex-column shadow" style="width: 260px;">
            <div class="p-3 border-bottom border-secondary border-opacity-25">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none d-flex align-items-center p-2">
                    <i class="bi bi-shop fs-4 me-2"></i>
                    <span class="fs-5 fw-bold">Admin Panel</span>
                </a>
                {{-- TAMBAHAN: Tombol Lihat Toko di Bawah Judul Admin --}}
                <div class="px-2 mt-2">
                    <a href="/" target="_blank" class="btn btn-view-store w-100 rounded-pill py-1">
                        <i class="bi bi-eye me-2"></i> Lihat Toko
                    </a>
                </div>
            </div>

            <nav class="flex-grow-1 py-3 overflow-auto">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-section-title">Katalog & Stok</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.products.index') ? route('admin.products.index') : '#' }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam me-2"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.categories.index') ? route('admin.categories.index') : '#' }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="bi bi-folder me-2"></i> Kategori
                        </a>
                    </li>

                    <li class="nav-section-title">Transaksi</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="bi bi-receipt me-2"></i> <span class="flex-grow-1">Pesanan</span>
                            @php
                                try {
                                    $pendingCount = \App\Models\Order::where('status', 'pending')->count();
                                } catch (\Exception $e) { $pendingCount = 0; }
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge bg-warning text-dark">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-section-title">Management</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.users.index') ? route('admin.users.index') : '#' }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-people me-2"></i> Pengguna
                        </a>
                    </li>

                    <li class="nav-section-title">Laporan</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.reports.sales') ? route('admin.reports.sales') : '#' }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <i class="bi bi-graph-up me-2"></i> Laporan Penjualan
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-3 border-top border-secondary border-opacity-25">
                <div class="d-flex align-items-center text-white">
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="small fw-bold">{{ auth()->user()->name }}</div>
                        <div class="small text-muted" style="font-size: 0.7rem;">Administrator</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-grow-1">
            <header class="bg-white shadow-sm py-3 px-4 d-flex justify-content-between align-items-center sticky-top">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0 fw-bold me-3">@yield('page-title', 'Dashboard')</h4>
                    {{-- TAMBAHAN: Tombol Lihat Toko di Header (Badge Style) --}}
                    <a href="/" target="_blank" class="btn btn-sm btn-light border rounded-pill px-3 d-none d-md-block">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Toko
                    </a>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small d-none d-md-block me-2">{{ now()->format('d M Y') }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="p-4">
                {{-- Alert Success --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Alert Error --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>