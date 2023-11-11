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
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Parent Menu',
        ]);
        Menu::create([
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Sub Menu',
        ]);
        Menu::create([
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Role',
        ]);
        Menu::create([
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'User',
        ]);

        Menu::create([
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Angkatan'
        ]);
        Menu::create([
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Jurusan'
        ]);
        Menu::create([
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Kelas'
        ]);
        Menu::create([
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Mapel'
        ]);
        Menu::create([
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Data Siswa'
        ]);
        Menu::create([
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Ruangan'
        ]);
        Menu::create([
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Pengajuan'
        ]);

        Menu::create([
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Barang'
        ]);
        Menu::create([
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Distribusi'
        ]);
        Menu::create([
            'parent_menu' => 4,
            'akses_role' => 1,
            'nama_menu' => 'Data Karyawan',
        ]);
        Menu::create([
            'parent_menu' => 5,
            'akses_role' => 1,
            'nama_menu' => 'Buku Online',
        ]);
        Menu::create([
            'parent_menu' => 5,
            'akses_role' => 1,
            'nama_menu' => 'Data Peminjam',
        ]);
        Menu::create([
            'parent_menu' => 6,
            'akses_role' => 1,
            'nama_menu' => 'Tabungan Siswa',
        ]);
        Menu::create([
            'parent_menu' => 6,
            'akses_role' => 1,
            'nama_menu' => 'Log Tabungan',
        ]);
        
    }
}
