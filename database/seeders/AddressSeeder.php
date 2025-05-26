<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pembeli = User::where('email', 'pembeli@example.com')->first();

        Address::create([
            'user_id' => $pembeli->id,
            'recipient_name' => 'Budi Santoso',
            'phone' => '081234567890',
            'address_text' => 'Jl. Pahlawan No. 123, Kelurahan Sukamaju, Kota Padang, Sumatera Barat',
            'is_default' => true,
        ]);
    }
}
