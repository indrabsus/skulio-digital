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
            'path' => 'admin/role',
            'class' => 'App\Livewire\Admin\Role',
            'name' => 'admin.role',
            'parent_menu' => 'Admin',
            'akses_role' => 1,
            'nama_menu' => 'Role',
        ]);
        Menu::create([
            'path' => 'admin/angkatan',
            'class' => 'App\Livewire\Kurikulum\Angkatan',
            'name' => 'admin.angkatan',
            'parent_menu' => 'Kurikulum',
            'akses_role' => 1,
            'nama_menu' => 'Angkatan'
        ]);
        Menu::create([
            'path' => 'admin/jurusan',
            'class' => 'App\Livewire\Kurikulum\Jurusan',
            'name' => 'admin.jurusan',
            'parent_menu' => 'Kurikulum',
            'akses_role' => 1,
            'nama_menu' => 'Jurusan'
        ]);
        Menu::create([
            'path' => 'admin/kelas',
            'class' => 'App\Livewire\Kurikulum\Kelas',
            'name' => 'admin.kelas',
            'parent_menu' => 'Kurikulum',
            'akses_role' => 1,
            'nama_menu' => 'Kelas'
        ]);
        Menu::create([
            'path' => 'admin/mapel',
            'class' => 'App\Livewire\Kurikulum\Mapel',
            'name' => 'admin.mapel',
            'parent_menu' => 'Kurikulum',
            'akses_role' => 1,
            'nama_menu' => 'Mapel'
        ]);
        Menu::create([
            'path' => 'admin/ruangan',
            'class' => 'App\Livewire\Sarpras\Ruangan',
            'name' => 'admin.ruangan',
            'parent_menu' => 'Sarpras',
            'akses_role' => 1,
            'nama_menu' => 'Ruangan'
        ]);
        Menu::create([
            'path' => 'admin/barang',
            'class' => 'App\Livewire\Sarpras\Barang',
            'name' => 'admin.barang',
            'parent_menu' => 'Sarpras',
            'akses_role' => 1,
            'nama_menu' => 'Barang'
        ]);
    }
}
