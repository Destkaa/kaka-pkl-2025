{{-- ================================================
     FILE: resources/views/layouts/admin.blade.php
     FUNGSI: Master layout admin (Fixed Error 500)
     ================================================ --}}

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
                        <a href="{{ Route::has('admin.products.index') ? route('admin.products.index') : '#' }}" class="nav-link">
                            <i class="bi bi-box-seam me-2"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.categories.index') ? route('admin.categories.index') : '#' }}" class="nav-link">
                            <i class="bi bi-folder me-2"></i> Kategori
                        </a>
                    </li>

                    <li class="nav-section-title">Transaksi</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.orders.index') ? route('admin.orders.index') : '#' }}" class="nav-link">
                            <i class="bi bi-receipt me-2"></i> <span class="flex-grow-1">Pesanan</span>
                            @php
                                // Menggunakan try-catch agar tidak 500 jika tabel belum ada/model salah
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
                        <a href="{{ Route::has('admin.users.index') ? route('admin.users.index') : '#' }}" class="nav-link">
                            <i class="bi bi-people me-2"></i> Pengguna
                        </a>
                    </li>

                    <li class="nav-section-title">Laporan</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('admin.reports.sales') ? route('admin.reports.sales') : '#' }}" class="nav-link">
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
                <h4 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h4>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Logout</button>
                </form>
            </header>

            <main class="p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>