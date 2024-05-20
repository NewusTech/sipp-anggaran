<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetunjukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('petunjuk')->insert([
            [
                'title' => 'Halaman Dashboard',
                'detail' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'title' => 'Pengaturan Bidang',
                'detail' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'title' => 'Penginputan Kegiatan dan Paket Manual',
                'detail' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'title' => 'Penginputan Kegiatan dan Paket Upload dengan DPA',
                'detail' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'title' => 'Cetak Laporan',
                'detail' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'title' => 'Sistem Pengarsipan',
                'detail' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ]
        ]);
    }
}
