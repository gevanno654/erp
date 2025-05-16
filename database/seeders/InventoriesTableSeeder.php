<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventories = [
            [
                'name_items' => 'Pasir Silika Raw',
                'type_items' => 'Bahan Dasar',
                'items_stock' => 1000,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_items' => 'Pasir Silika Cuci',
                'type_items' => 'Produk Jadi',
                'items_stock' => 400,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_items' => 'Pasir Silika Kering',
                'type_items' => 'Produk Jadi',
                'items_stock' => 640,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_items' => 'Pasir Silika Cuci Kering',
                'type_items' => 'Produk Jadi',
                'items_stock' => 200,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_items' => 'Ekskavator',
                'type_items' => 'Alat Berat',
                'items_stock' => 6,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_items' => 'Loader',
                'type_items' => 'Alat Berat',
                'items_stock' => 2,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_items' => 'Forklift',
                'type_items' => 'Kendaraan',
                'items_stock' => 4,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_items' => 'Feeder dan Vibrating Screen',
                'type_items' => 'Mesin',
                'items_stock' => 2,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_items' => 'Mesin Pencuci Pasir (Sand Washer)',
                'type_items' => 'Mesin',
                'items_stock' => 2,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_items' => 'Mesin Pengayak',
                'type_items' => 'Mesin',
                'items_stock' => 2,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_items' => 'Mesin Pengering Pasir',
                'type_items' => 'Mesin',
                'items_stock' => 3,
                'updated_stock_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data ke tabel inventories
        DB::table('assets')->insert($inventories);
    }
}
