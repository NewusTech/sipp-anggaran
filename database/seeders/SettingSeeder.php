<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();
        Setting::create([
            'name' => 'PU-Net',
            'logo' => 'logo/default.png',
            'email' => 'pu-net@example.com',
            'phone_number' => '+(62)821 7766 2211',
            'address' => 'Bandar Lampung',
            'facebook' => 'https://facebook.com',
            'youtube' => 'https://youtube.com',
            'instagram' => 'https://instagram.com',
            // 'twitter ' => 'https://twitter.com'
        ]);
    }
}
