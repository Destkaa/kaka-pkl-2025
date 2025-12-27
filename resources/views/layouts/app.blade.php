{{-- ================================================
     FILE: resources/views/layouts/app.blade.php
     FUNGSI: Master layout untuk halaman customer/publik
     ================================================ --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    {{-- Favicon --}}
    {{-- Perbaikan: Tambahkan type untuk memastikan browser mengenali file ico/png --}}
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Stack untuk script atau style tambahan dari child view di bagian Head --}}
    @stack('styles')
    @stack('scripts_head')
</head>

<body>
    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- FLASH MESSAGES --}}
    <div class="container mt-3">
        @include('partials.flash-messages')
    </div>

    {{-- CONTENT --}}
    <main class="min-vh-100">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    {{-- SCRIPT AREA --}}
    {{-- Tempat script library luar jika ada --}}
    @stack('scripts')

    {{-- Script Global (Wishlist dll) --}}
    <script>
        /**
         * Logic Wishlist
         */
        async function toggleWishlist(productId) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch(`/wishlist/toggle/${productId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },
                });

                if (response.status === 401) {
                    window.location.href = "/login";
                    return;
                }

                const data = await response.json();

                if (data.status === "success") {
                    updateWishlistUI(productId, data.added);
                    updateWishlistCounter(data.count);
                    
                    if (typeof showToast === "function") {
                        showToast(data.message);
                    } else {
                        // Fallback sederhana jika toast tidak aktif
                        console.log(data.message);
                    }
                }
            } catch (error) {
                console.error("Wishlist Error:", error);
            }
        }

        function updateWishlistUI(productId, isAdded) {
            document.querySelectorAll(`.wishlist-btn-${productId}`).forEach(btn => {
                const icon = btn.querySelector("i");
                if (!icon) return;

                if (isAdded) {
                    icon.classList.add("bi-heart-fill", "text-danger");
                    icon.classList.remove("bi-heart", "text-secondary");
                } else {
                    icon.classList.remove("bi-heart-fill", "text-danger");
                    icon.classList.add("bi-heart", "text-secondary");
                }
            });
        }

        function updateWishlistCounter(count) {
            const badge = document.getElementById("wishlist-count");
            if (!badge) return;

            badge.innerText = count;
            badge.style.display = count > 0 ? "inline-block" : "none";
        }
    </script>
</body>
</html>