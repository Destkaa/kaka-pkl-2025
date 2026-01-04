<!DOCTYPE html>
<html>
<body>
    <h1>Pembayaran Berhasil!</h1>
    <p>Halo, pesanan Anda dengan ID <strong>#<?php echo e($order->id); ?></strong> telah kami terima.</p>
    <p>Status: <span style="color: green;">PAID</span></p>
    <p>Tanggal Laporan: <?php echo e($startDate); ?> sampai <?php echo e($endDate); ?></p>
    <hr>
    <p>Terima kasih telah berbelanja di Gadget Murah!</p>
</body>
</html><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/emails/sales_report.blade.php ENDPATH**/ ?>