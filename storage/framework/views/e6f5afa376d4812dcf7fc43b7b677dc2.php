<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo $__env->yieldContent('title', 'Toko Online'); ?> - <?php echo e(config('app.name')); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Floating Notification System */
        #notification-container {
            position: fixed;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10000;
            width: 90%;
            max-width: 400px;
            pointer-events: none;
        }

        #notification-container .alert {
            pointer-events: auto;
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
            padding: 1rem 1.25rem;
            margin-bottom: 10px;
            animation: slideDown 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .alert-success { background-color: #10b981; color: white; }
        .alert-danger { background-color: #ef4444; color: white; }
        .alert-info { background-color: #3b82f6; color: white; }
        
        .btn-close-white { filter: brightness(0) invert(1); }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div id="notification-container">
        <?php echo $__env->make('partials.flash-messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <main class="min-vh-100">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        /**
         * Menampilkan notifikasi melayang secara dinamis
         */
        function showAlert(message, type = 'success') {
            const container = document.getElementById('notification-container');
            const id = 'alert-' + Math.random().toString(36).substr(2, 9);
            
            // Mapping icon berdasarkan tipe
            const icons = {
                'success': 'bi-check-circle-fill',
                'danger': 'bi-exclamation-octagon-fill',
                'warning': 'bi-exclamation-triangle-fill',
                'info': 'bi-info-circle-fill'
            };

            const alertHtml = `
                <div id="${id}" class="alert alert-${type} d-flex align-items-center justify-content-between fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi ${icons[type] || icons.info} fs-5 me-3"></i>
                        <span class="fw-medium">${message}</span>
                    </div>
                    <button type="button" class="btn-close ${type !== 'light' ? 'btn-close-white' : ''} ms-3" 
                            data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', alertHtml);
            
            // Auto remove setelah 4 detik
            setTimeout(() => {
                const el = document.getElementById(id);
                if(el) {
                    el.classList.replace('show', 'hide');
                    setTimeout(() => el.remove(), 400);
                }
            }, 4000);
        }

        /**
         * Fitur Wishlist AJAX
         */
        async function toggleWishlist(productId) {
            const token = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch(`/wishlist/toggle/${productId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },
                });

                if (response.status === 401) {
                    showAlert("Silahkan login terlebih dahulu", "info");
                    setTimeout(() => window.location.href = "/login", 1500);
                    return;
                }

                const data = await response.json();
                
                if (data.status === "success") {
                    updateWishlistUI(productId, data.added);
                    updateWishlistCounter(data.count);
                    showAlert(data.message, 'success');

                    // Jika di halaman wishlist dan produk dihapus, refresh halaman
                    if (window.location.pathname.includes('/wishlist') && !data.added) {
                        setTimeout(() => location.reload(), 800);
                    }
                }
            } catch (error) {
                showAlert("Terjadi kesalahan koneksi", "danger");
            }
        }

        function updateWishlistUI(productId, isAdded) {
            document.querySelectorAll(`.wishlist-btn-${productId}`).forEach(btn => {
                const icon = btn.querySelector("i");
                if (icon) {
                    icon.className = isAdded ? "bi bi-heart-fill text-danger" : "bi bi-heart text-secondary";
                    // Tambahkan efek animasi kecil
                    icon.style.transform = "scale(1.2)";
                    setTimeout(() => icon.style.transform = "scale(1)", 200);
                }
            });
        }

        function updateWishlistCounter(count) {
            const badge = document.getElementById("wishlist-count");
            if (badge) {
                badge.innerText = count;
                badge.classList.toggle('d-none', count === 0);
            }
        }
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/layouts/app.blade.php ENDPATH**/ ?>