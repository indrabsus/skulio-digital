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
            'path' => 'admin/dashboard',
            'class' => 'App\Livewire\Admin\Dashboard',
            'name' => 'admin.dashboard',
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Dashboard',
        ]);
        Menu::create([
            'sort' => 2,
            'path' => 'admin/parentmenu',
            'class' => 'App\Livewire\Admin\ParentMenu',
            'name' => 'admin.parentmenu',
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Parent Menu',
        ]);
        Menu::create([
            'sort' => 3,
            'path' => 'admin/role',
            'class' => 'App\Livewire\Admin\Role',
            'name' => 'admin.role',
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Role',
        ]);
        Menu::create([
            'sort' => 11,
            'path' => 'admin/angkatan',
            'class' => 'App\Livewire\Kurikulum\Angkatan',
            'name' => 'admin.angkatan',
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Angkatan'
        ]);
        Menu::create([
            'sort' => 12,
            'path' => 'admin/jurusan',
            'class' => 'App\Livewire\Kurikulum\Jurusan',
            'name' => 'admin.jurusan',
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Jurusan'
        ]);
        Menu::create([
            'sort' => 13,
            'path' => 'admin/kelas',
            'class' => 'App\Livewire\Kurikulum\Kelas',
            'name' => 'admin.kelas',
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Kelas'
        ]);
        Menu::create([
            'sort' => 14,
            'path' => 'admin/mapel',
            'class' => 'App\Livewire\Kurikulum\Mapel',
            'name' => 'admin.mapel',
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Mapel'
        ]);
        Menu::create([
            'sort' => 21,
            'path' => 'admin/ruangan',
            'class' => 'App\Livewire\Sarpras\Ruangan',
            'name' => 'admin.ruangan',
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Ruangan'
        ]);
        Menu::create([
            'sort' => 22,
            'path' => 'admin/barang',
            'class' => 'App\Livewire\Sarpras\Barang',
            'name' => 'admin.barang',
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Barang'
        ]);
    }
}
