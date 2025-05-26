<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ikan = Product::where('name', 'Ikan Kering')->first();
        $lado = Product::where('name', 'Lado Merah Giliang')->first();

        ProductVariant::insert([
            [
                'product_id' => $ikan->id,
                'variant' => 'Kemasan 250g',
                'price' => 29000,
                'stock' => 100,
                'created_at' => now()
            ],
            [
                'product_id' => $ikan->id,
                'variant' => 'Kemasan 500g',
                'price' => 87040,
                'stock' => 50,
                'created_at' => now()
            ],
            [
                'product_id' => $lado->id,
                'variant' => 'Kemasan 250g',
                'price' => 36224,
                'stock' => 75,
                'created_at' => now()
            ],
        ]);
    }
}
