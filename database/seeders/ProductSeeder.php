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
        $penjual = \App\Models\User::where('role', 'seller')->first();

        Product::insert([
            [
                'seller_id' => $penjual->id,
                'name' => 'Ikan Kering',
                'description' => 'Ikan kering laut berkualitas.',
                'price' => 0, // gunakan varian
                'category' => 'Ikan',
                'stock' => 0,
                'image' => 'ikan_kering.jpg',
                'created_at' => now()
            ],
            [
                'seller_id' => $penjual->id,
                'name' => 'Lado Merah Giliang',
                'description' => 'Cabai merah khas Sumatera.',
                'price' => 0,
                'category' => 'Rempah',
                'stock' => 0,
                'image' => 'lado_merah.jpg',
                'created_at' => now()
            ]
        ]);
    }
}
