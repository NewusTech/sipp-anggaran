<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Kepala Dinas',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Kepala Bidang',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Staff Pelaksana',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Staff Pengawasan',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Staff Keuangan',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Staff Administrasi',
            'guard_name' => 'web'
        ]);
    }
}
