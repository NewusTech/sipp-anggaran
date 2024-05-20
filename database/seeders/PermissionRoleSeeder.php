<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kepala_dinas = Role::findById(2);
        $kepala_bidang = Role::findById(3);
        $staff_pelaksana = Role::findById(4);
        $staff_pengawasan = Role::findById(5);
        $staff_keuangan = Role::findById(6);
        $staff_administrasi = Role::findById(7);

        $kepala_dinas->givePermissionTo([
            'lihat dasbor',
            'lihat pengguna',
            'tambah pengguna',
            'ubah pengguna',
            'hapus pengguna',
            'tambah pengguna bidang',
            'lihat petunjuk',
            'lihat informasi utama'
        ]);

        $kepala_bidang->givePermissionTo([
            'lihat dasbor',
            'lihat pengguna',
            'tambah pengguna',
            'ubah pengguna',
            'hapus pengguna',
            'lihat petunjuk',
            'tambah petunjuk',
            'ubah petunjuk',
            'lihat informasi utama',
            'lihat kegiatan',
            'tambah kegiatan',
            'ubah kegiatan',
            'hapus kegiatan',
            'lihat detail kegiatan',
            'tambah detail kegiatan',
            'ubah detail kegiatan',
            'hapus detail kegiatan',
            'lihat anggaran',
            'tambah anggaran',
            'ubah anggaran',
            'hapus anggaran',
            'lihat dokumentasi',
            'tambah dokumentasi',
            'ubah dokumentasi',
            'hapus dokumentasi',
            'lihat penyedia jasa',
            'tambah penyedia jasa',
            'ubah penyedia jasa',
            'hapus penyedia jasa',
            'lihat nomenklatur',
            'tambah nomenklatur',
            'ubah nomenklatur',
            'hapus nomenklatur',
            'lihat role',
            'tambah role',
            'ubah role',
            'hapus role',
            'lihat permission',
            'tambah permission',
            'ubah permission',
            'hapus permission',
            'cetak laporan',
            'lihat urusan',
            'tambah urusan',
            'ubah urusan',
            'hapus urusan',
            'lihat organisasi',
            'tambah organisasi',
            'ubah organisasi',
            'hapus organisasi',
            'lihat unit',
            'tambah unit',
            'ubah unit',
            'hapus unit',
            'lihat sumber dana',
            'tambah sumber dana',
            'ubah sumber dana',
            'hapus sumber dana',
            'lihat dpa',
            'tambah dpa',
            'ubah dpa',
            'hapus dpa',
        ]);

        $staff_pelaksana->givePermissionTo([
            'lihat dasbor',
            'lihat arsip',
            'tambah arsip',
            'hapus arsip',
            'lihat kegiatan',
            'tambah kegiatan',
            'ubah kegiatan',
            'hapus kegiatan',
            'lihat detail kegiatan',
            'tambah detail kegiatan',
            'ubah detail kegiatan',
            'hapus detail kegiatan',
            'lihat anggaran',
            'tambah anggaran',
            'ubah anggaran',
            'hapus anggaran',
            'lihat dokumentasi',
            'tambah dokumentasi',
            'ubah dokumentasi',
            'hapus dokumentasi',
            'cetak laporan',
            'lihat petunjuk',
            'lihat informasi utama'
        ]);

        $staff_pengawasan->givePermissionTo([
            'lihat dasbor',
            'lihat arsip',
            'lihat kegiatan',
            'lihat detail kegiatan',
            'lihat anggaran',
            'lihat dokumentasi',
            'cetak laporan',
            'lihat petunjuk',
            'lihat informasi utama'
        ]);

        $staff_keuangan->givePermissionTo([
            'lihat dasbor',
            'ubah sumber dana',
            'lihat arsip',
            'lihat kegiatan',
            'lihat detail kegiatan',
            'lihat anggaran',
            'lihat dokumentasi',
            'cetak laporan',
            'lihat petunjuk',
            'lihat informasi utama'
        ]);

        $staff_administrasi->givePermissionTo([
            'lihat dasbor',
            'lihat arsip',
            'lihat kegiatan',
            'lihat detail kegiatan',
            'lihat anggaran',
            'lihat dokumentasi',
            'lihat petunjuk',
            'lihat informasi utama'
        ]);
    }
}
