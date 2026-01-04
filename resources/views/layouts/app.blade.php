<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    {{-- Container Notifikasi --}}
    <div id="notification-container" class="container mt-3">
        @include('partials.flash-messages')
    </div>

    <main class="min-vh-100">
        @yield('content')
    </main>

    @include('partials.footer')
    @stack('scripts')

    <script>
        // Fungsi Notifikasi (Sama seperti Cart)
        function showAlert(message, type = 'success') {
            const container = document.getElementById('notification-container');
            container.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show shadow-sm" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            // Auto hide setelah 3 detik
            setTimeout(() => {
                const alert = document.querySelector('#notification-container .alert');
                if(alert) alert.remove();
            }, 3000);
        }

        async function toggleWishlist(productId) {
            try {
                const response = await fetch(`/wishlist/toggle/${productId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    },
                });

                if (response.status === 401) return window.location.href = "/login";

                const data = await response.json();
                if (data.status === "success") {
                    updateWishlistUI(productId, data.added);
                    updateWishlistCounter(data.count);
                    
                    // Munculkan notifikasi teks di bawah navbar
                    showAlert(data.message);

                    if (window.location.pathname.includes('/wishlist') && !data.added) {
                        location.reload();
                    }
                }
            } catch (error) {
                showAlert("Gagal memproses wishlist", "danger");
            }
        }

        function updateWishlistUI(productId, isAdded) {
            document.querySelectorAll(`.wishlist-btn-${productId}`).forEach(btn => {
                const icon = btn.querySelector("i");
                if (icon) icon.className = isAdded ? "bi bi-heart-fill text-danger" : "bi bi-heart text-secondary";
            });
        }

        function updateWishlistCounter(count) {
            const badge = document.getElementById("wishlist-count");
            if (badge) {
                badge.innerText = count;
                badge.style.display = count > 0 ? "inline-block" : "none";
            }
        }
    </script>
</body>
</html>