<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->insert([
            ['option_key' => 'slide_1', 'option_value' => 'https://www.claudeusercontent.com/api/placeholder/480/150'],
            ['option_key' => 'slide_2', 'option_value' => 'https://www.claudeusercontent.com/api/placeholder/480/150'],
            ['option_key' => 'slide_3', 'option_value' => 'https://www.claudeusercontent.com/api/placeholder/480/150'],
            ['option_key' => 'admin_contact', 'option_value' => '62811662373'],
            ['option_key' => 'promo_code', 'option_value' => '11'],
            ['option_key' => 'discount', 'option_value' => '0.1'],
        ]);
    }
}
