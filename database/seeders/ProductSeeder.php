<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'nama_produk' => 'Produk A',
            'deskripsi_produk' => 'Sample produk A.'
        ]);

        Product::create([
            'nama_produk' => 'Produk B',
            'deskripsi_produk' => 'Sample produk B.'
        ]);
    }
}
