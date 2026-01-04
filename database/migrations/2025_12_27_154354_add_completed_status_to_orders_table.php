<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kita definisikan ulang enum dengan menyertakan 'completed'
            $table->enum('status', [
                'pending', 
                'processing', 
                'shipped', 
                'delivered', 
                'completed', // Ini yang tadi bikin error karena belum ada
                'cancelled'
            ])->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Balikkan ke kondisi awal jika migrasi di-rollback
            $table->enum('status', [
                'pending', 
                'processing', 
                'shipped', 
                'delivered', 
                'cancelled'
            ])->default('pending')->change();
        });
    }
};