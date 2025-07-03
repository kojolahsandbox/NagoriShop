<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Carbon;

use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pembeli = User::where('email', 'pembeli@example.com')->first();
        $alamat = Address::where('user_id', $pembeli->id)->first();

        Order::insert([
            [
                'id' => Str::uuid(),
                'user_id' => $pembeli->id,
                'address_id' => $alamat->id,
                'shipping_fee' => 18000,
                'shipping_status' => 'confirmed',
                'payment_method' => 'Nagori Pay',
                'note' => 'Tolong dikirim cepat ya.',
                'status' => 'completed',
                'total_amount' => 133264,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(2),
            ],
            [
                'id' => Str::uuid(),
                'user_id' => $pembeli->id,
                'address_id' => $alamat->id,
                'shipping_fee' => 10000,
                'shipping_status' => 'confirmed',
                'payment_method' => 'Nagori Pay',
                'note' => null,
                'status' => 'shipped',
                'total_amount' => 65224,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDay(),
            ],
            [
                'id' => Str::uuid(),
                'user_id' => $pembeli->id,
                'address_id' => $alamat->id,
                'shipping_fee' => 8000,
                'shipping_status' => 'confirmed',
                'payment_method' => 'Nagori Pay',
                'note' => null,
                'status' => 'paid',
                'total_amount' => 117040,
                'created_at' => now()->subDay(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'user_id' => $pembeli->id,
                'address_id' => $alamat->id,
                'shipping_fee' => 0,
                'shipping_status' => 'pending',
                'payment_method' => null,
                'note' => null,
                'status' => 'waiting_payment',
                'total_amount' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'user_id' => $pembeli->id,
                'address_id' => $alamat->id,
                'shipping_fee' => 0,
                'shipping_status' => 'pending',
                'payment_method' => null,
                'note' => null,
                'status' => 'draft',
                'total_amount' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
