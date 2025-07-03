<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ikan = Product::where('name', 'Ikan Kering')->first();
        $lado = Product::where('name', 'Lado Merah Giliang')->first();

        $ikan500 = ProductVariant::where('product_id', $ikan->id)->where('variant', 'Kemasan 500g')->first();
        $ikan250 = ProductVariant::where('product_id', $ikan->id)->where('variant', 'Kemasan 250g')->first();
        $lado250 = ProductVariant::where('product_id', $lado->id)->where('variant', 'Kemasan 250g')->first();

        $orders = Order::all();

        // Transaksi "completed"
        OrderItem::insert([
            [
                'id' => Str::uuid(),
                'order_id' => $orders[0]->id,
                'product_id' => $ikan->id,
                'product_name' => 'Ikan Kering',
                'variant' => 'Kemasan 500g',
                'quantity' => 1,
                'unit_price' => 87040,
            ],
            [
                'id' => Str::uuid(),
                'order_id' => $orders[0]->id,
                'product_id' => $lado->id,
                'product_name' => 'Lado Merah Giliang',
                'variant' => 'Kemasan 250g',
                'quantity' => 1,
                'unit_price' => 36224,
            ],
        ]);

        // Transaksi "shipped"
        OrderItem::insert([
            'id' => Str::uuid(),
            'order_id' => $orders[1]->id,
            'product_id' => $lado->id,
            'product_name' => 'Lado Merah Giliang',
            'variant' => 'Kemasan 250g',
            'quantity' => 1,
            'unit_price' => 36224,
        ]);

        // Transaksi "paid"
        OrderItem::insert([
            'id' => Str::uuid(),
            'order_id' => $orders[2]->id,
            'product_id' => $ikan->id,
            'product_name' => 'Ikan Kering',
            'variant' => 'Kemasan 500g',
            'quantity' => 1,
            'unit_price' => 87040,
        ]);

        // Transaksi lainnya (waiting_payment dan draft) tidak diberi item dulu
    }
}
