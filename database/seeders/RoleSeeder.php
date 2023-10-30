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
            'nama_role' => 'admin',
            'icon' => 'hash',
        ]);
        Role::create([
            'nama_role' => 'kurikulum',
            'icon' => 'book-open',
        ]);
        Role::create([
            'nama_role' => 'sarpras',
            'icon' => 'layers',
        ]);
        Role::create([
            'nama_role' => 'verifikator',
            'icon' => 'activity',
        ]);
    }
}
