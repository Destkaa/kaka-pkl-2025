<?php

namespace App\Listeners;

use App\Events\OrderPaidEvent;
use App\Mail\SalesReportMail;
use Illuminate\Contracts\Queue\ShouldQueue; 
use Illuminate\Support\Facades\Mail;

class SendOrderPaidEmail implements ShouldQueue 
{
    public function handle(OrderPaidEvent $event): void
    {
        // 1. Tambahkan pengecekan User agar tidak error jika data user kosong
        if (!$event->order || !$event->order->user) {
            return;
        }

        // 2. Kirim email
        Mail::to($event->order->user->email)->send(new SalesReportMail(
            $event->order, 
            now()->toDateString(), 
            now()->toDateString()
        ));
    }
}