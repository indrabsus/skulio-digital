<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'nama_role' => 'admin'
        ]);
        Role::create([
            'nama_role' => 'kurikulum'
        ]);
        Role::create([
            'nama_role' => 'sarpras'
        ]);
        Role::create([
            'nama_role' => 'verifikator'
        ]);
    }
}
