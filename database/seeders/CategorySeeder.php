<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Smartphone',
                'slug'        => 'smartphone',
                'description' => 'Berbagai pilihan smartphone terbaru dari brand ternama seperti iPhone, Samsung, dan Pixel.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Laptop & PC',
                'slug'        => 'laptop-pc',
                'description' => 'Laptop gaming, ultrabook, hingga PC rakitan dengan spesifikasi pro.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Audio & Wearables',
                'slug'        => 'audio-wearables',
                'description' => 'TWS, Headphone, Smartwatch, dan perangkat pelengkap gaya hidup digital.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Aksesoris Gadget',
                'slug'        => 'aksesoris-gadget',
                'description' => 'Charger, casing, kabel data, dan perlengkapan gadget lainnya.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Gaming Gears',
                'slug'        => 'gaming-gears',
                'description' => 'Console, controller, hingga kursi gaming untuk pengalaman main maksimal.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Kamera & Lensa',
                'slug'        => 'kamera-lensa',
                'description' => 'Kamera mirrorless, DSLR, dan lensa untuk para fotografer pro.',
                'is_active'   => true,
            ],
        ];

        // Kosongkan tabel kategori terlebih dahulu agar tidak duplikat saat dijalankan ulang
        // Category::truncate(); 

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Mantap Lek! Data kategori GADGETPRO berhasil masuk ke database.');
    }
}