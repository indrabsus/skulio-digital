<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'sort' => 1,
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Dashboard',
        ]);
        Menu::create([
            'sort' => 2,
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Parent Menu',
        ]);
        Menu::create([
            'sort' => 3,
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Sub Menu',
        ]);
        Menu::create([
            'sort' => 4,
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Role',
        ]);
        Menu::create([
            'sort' => 11,
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Angkatan'
        ]);
        Menu::create([
            'sort' => 12,
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Jurusan'
        ]);
        Menu::create([
            'sort' => 13,
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Kelas'
        ]);
        Menu::create([
            'sort' => 14,
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Mapel'
        ]);
        Menu::create([
            'sort' => 21,
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Ruangan'
        ]);
        Menu::create([
            'sort' => 22,
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Barang'
        ]);
    }
}
