<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use App\Listeners\MergeCartListener;
use App\Events\OrderPaidEvent;
// Sesuaikan nama di sini dengan nama file yang ada di folder Listeners Anda
use App\Listeners\SendOrderPaidEmail; 
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            MergeCartListener::class,
        ],
        OrderPaidEvent::class => [
            // Gunakan nama class yang benar
            SendOrderPaidEmail::class, 
        ],
    ];
}