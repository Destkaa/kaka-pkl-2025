

<footer class="footer-custom bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white mb-3 d-flex align-items-center">
                    <span class="icon-circle-purple me-2">
                        <i class="bi bi-bag-heart-fill"></i>
                    </span>
                    TokoOnline
                </h5>
                <p class="text-secondary pe-lg-4">
                    Toko online terpercaya dengan berbagai produk berkualitas.
                    Belanja mudah, aman, dan nyaman.
                </p>
                
                
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="social-link-purple"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/destkaaa_13/" target="_blank" class="social-link-purple"><i class="bi bi-instagram"></i></a>
                    <a href="https://github.com/Destkaa" target="_blank" class="social-link-purple"><i class="bi bi-github"></i></a>
                    <a href="#" class="social-link-purple"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-title mb-4">Menu</h6>
                <ul class="list-unstyled footer-list">
                    <li class="mb-2">
                        <a href="<?php echo e(route('catalog.index')); ?>">Katalog Produk</a>
                    </li>
                    <li class="mb-2"><a href="#">Tentang Kami</a></li>
                    <li class="mb-2"><a href="#">Kontak</a></li>
                </ul>
            </div>

            
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-title mb-4">Bantuan</h6>
                <ul class="list-unstyled footer-list">
                    <li class="mb-2"><a href="#">FAQ</a></li>
                    <li class="mb-2"><a href="#">Cara Belanja</a></li>
                    <li class="mb-2"><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>

            
            <div class="col-lg-4 col-md-6">
                <h6 class="footer-title mb-4">Hubungi Kami</h6>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt me-3 purple-text"></i>
                        <span class="text-secondary small">Jl. Contoh No. 123, Bandung</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-telephone me-3 purple-text"></i>
                        <span class="text-secondary small">(022) 123-4567</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-envelope me-3 purple-text"></i>
                        <span class="text-secondary small">info@tokoonline.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-secondary opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-secondary mb-0 small">
                    &copy; <?php echo e(date('Y')); ?> <span class="purple-text fw-bold">TokoOnline</span>. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <div class="payment-badges">
                    <i class="bi bi-credit-card-2-back me-2 opacity-50"></i>
                    <i class="bi bi-shield-check me-2 opacity-50"></i>
                    <i class="bi bi-wallet2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Base Footer */
    .footer-custom {
        background-color: #121416 !important; /* Warna hitam yang lebih dalam */
    }

    /* Judul dengan garis bawah ungu */
    .footer-title {
        color: #ffffff;
        font-weight: 700;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 30px;
        height: 2px;
        background-color: #845ef7; /* Warna Ungu */
    }

    /* List link hover effect */
    .footer-list a {
        color: #adb5bd !important;
        text-decoration: none !important;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .footer-list a:hover {
        color: #845ef7 !important;
        padding-left: 5px;
    }

    /* Ikon Sosial Media Ungu */
    .social-link-purple {
        width: 40px;
        height: 40px;
        background-color: rgba(132, 94, 247, 0.1);
        color: #845ef7 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.3s ease;
        text-decoration: none !important;
    }

    .social-link-purple:hover {
        background-color: #845ef7;
        color: #ffffff !important;
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(132, 94, 247, 0.4);
    }

    /* Helper Classes */
    .purple-text {
        color: #845ef7;
    }

    .icon-circle-purple {
        background-color: #845ef7;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    /* Menghilangkan garis biru pada semua link di footer */
    .footer-custom a {
        outline: none !important;
        box-shadow: none !important;
    }
</style><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/partials/footer.blade.php ENDPATH**/ ?>