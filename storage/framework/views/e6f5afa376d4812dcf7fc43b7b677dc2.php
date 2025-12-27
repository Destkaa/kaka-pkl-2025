

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <title><?php echo $__env->yieldContent('title', 'Toko Online'); ?> - <?php echo e(config('app.name')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Toko online terpercaya dengan produk berkualitas'); ?>">

    
    
    <link rel="icon" type="image/png" href="<?php echo e(asset('logo.png')); ?>">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo $__env->yieldPushContent('scripts_head'); ?>
</head>

<body>
    
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="container mt-3">
        <?php echo $__env->make('partials.flash-messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <main class="min-vh-100">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    
    <?php echo $__env->yieldPushContent('scripts'); ?>

    
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
</html><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/layouts/app.blade.php ENDPATH**/ ?>