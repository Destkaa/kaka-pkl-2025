{{-- ================================================
     FILE: resources/views/layouts/app.blade.php
     FUNGSI: Master layout untuk halaman customer/publik
     ================================================ --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CSS tambahan --}}
    @stack('styles')
</head>

<body>
    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- FLASH --}}
    <div class="container mt-3">
        @include('partials.flash-messages')
    </div>

    {{-- CONTENT --}}
    <main class="min-vh-100">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    {{-- TEMPAT SCRIPT (PASTIKAN @STACK ADA DI DALAM BODY) --}}
    @stack('scripts')

    {{-- ============================================
         SCRIPT WISHLIST (DIMASUKKAN KE DALAM LAYOUT)
         ============================================ --}}
    <script>
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
                    
                    // Cek jika fungsi showToast tersedia
                    if (typeof showToast === "function") {
                        showToast(data.message);
                    } else {
                        alert(data.message);
                    }
                }
            } catch (error) {
                console.error(error);
                if (typeof showToast === "function") {
                    showToast("Terjadi kesalahan sistem.", "error");
                }
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