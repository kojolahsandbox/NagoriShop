<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin Utama',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'administrator',
                'status' => 'active',
                'created_at' => now()
            ],
            [
                'name' => 'Toko Nagori',
                'email' => 'penjual@example.com',
                'password' => Hash::make('password'),
                'role' => 'seller',
                'status' => 'nonactive',
                'created_at' => now()
            ],
            [
                'name' => 'Pembeli Budi',
                'email' => 'pembeli@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'status' => 'pending',
                'created_at' => now()
            ],
        ]);
    }
}
