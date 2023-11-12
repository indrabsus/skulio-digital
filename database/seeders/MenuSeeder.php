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
            'class' => 'Admin\ParentMenu'
        ]);
        Menu::create([
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Sub Menu',
            'class' => 'Admin\SubMenu',
        ]);
        Menu::create([
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'Role',
            'class' => 'Admin\Role'
        ]);
        Menu::create([
            'parent_menu' => 1,
            'akses_role' => 1,
            'nama_menu' => 'User',
            'class' => 'Admin\User'
        ]);

        Menu::create([
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Angkatan',
            'class' => 'Kurikulum\Angkatan',
        ]);
        Menu::create([
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Jurusan',
            'class' => 'Kurikulum\Jurusan',
        ]);
        Menu::create([
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Kelas',
            'class' => 'Kurikulum\Kelas',
        ]);
        Menu::create([
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Mapel',
            'class' => 'Kurikulum\Mapel',
        ]);
        Menu::create([
            'parent_menu' => 2,
            'akses_role' => 1,
            'nama_menu' => 'Data Siswa',
            'class' => 'Kurikulum\DataSiswa',
        ]);
        Menu::create([
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Ruangan',
            'class' => 'Sarpras\Ruangan',
        ]);
        Menu::create([
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Pengajuan',
            'class' => 'Sarpras\Pengajuan',
        ]);

        Menu::create([
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Barang',
            'class' => 'Sarpras\Barang',
        ]);
        Menu::create([
            'parent_menu' => 3,
            'akses_role' => 1,
            'nama_menu' => 'Distribusi',
            'class' => 'Sarpras\Distribusi',
        ]);
        Menu::create([
            'parent_menu' => 4,
            'akses_role' => 1,
            'nama_menu' => 'Data Karyawan',
            'class' => 'Manajemen\DataKaryawan',
        ]);
        Menu::create([
            'parent_menu' => 5,
            'akses_role' => 1,
            'nama_menu' => 'Buku Online',
            'class' => 'Perpustakaan\BukuOnline',
        ]);
        Menu::create([
            'parent_menu' => 5,
            'akses_role' => 1,
            'nama_menu' => 'Data Peminjam',
            'class' => 'Perpustakaan\DataPeminjam',
        ]);
        Menu::create([
            'parent_menu' => 6,
            'akses_role' => 1,
            'nama_menu' => 'Tabungan Siswa',
            'class' => 'BankMini\TabunganSiswa',
        ]);
        Menu::create([
            'parent_menu' => 6,
            'akses_role' => 1,
            'nama_menu' => 'Log Tabungan',
            'class' => 'BankMini\LogTabungan',
        ]);

    }
}
