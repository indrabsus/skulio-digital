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
            'parent_menu' => 5,
            'akses_role' => 1,
            'nama_menu' => 'Status Pinjam',
            'class' => 'Perpustakaan\DaftarPeminjamBuku',
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
        Menu::create([
            'parent_menu' => 6,
            'akses_role' => 8,
            'nama_menu' => 'Tabunganku',
            'class' => 'BankMini\LogTabungan',
        ]);
        Menu::create([
            'parent_menu' => 7,
            'akses_role' => 1,
            'nama_menu' => 'Manajemen Ujian',
            'class' => 'Sitepat\UjianMgmt',
        ]);
        Menu::create([
            'parent_menu' => 7,
            'akses_role' => 1,
            'nama_menu' => 'Log Ujian',
            'class' => 'Sitepat\LogUjian',
        ]);
        Menu::create([
            'parent_menu' => 7,
            'akses_role' => 1,
            'nama_menu' => 'Log Kecurangan',
            'class' => 'Sitepat\LogKecurangan',
        ]);
        Menu::create([
            'parent_menu' => 7,
            'akses_role' => 8,
            'nama_menu' => 'Ujianku',
            'class' => 'Sitepat\UjianMgmt',
        ]);

        Menu::create([
            'parent_menu' => 6,
            'akses_role' => 1,
            'nama_menu' => 'Laporan Tabungan',
            'class' => 'BankMini\LaporanTabungan',
        ]);

        Menu::create([
            'parent_menu' => 6,
            'akses_role' => 9,
            'nama_menu' => 'Tabungan Siswa',
            'class' => 'BankMini\TabunganSiswa',
        ]);

        Menu::create([
            'parent_menu' => 6,
            'akses_role' => 9,
            'nama_menu' => 'Log Tabungan',
            'class' => 'BankMini\LogTabungan',
        ]);

        Menu::create([
            'parent_menu' => 8,
            'akses_role' => 1,
            'nama_menu' => 'Master PPDB',
            'class' => 'Ppdb\MasterPpdb',
        ]);

        Menu::create([
            'parent_menu' => 8,
            'akses_role' => 1,
            'nama_menu' => 'Jurusan PPDB',
            'class' => 'Ppdb\JurusanPpdb',
        ]);

        Menu::create([
            'parent_menu' => 8,
            'akses_role' => 1,
            'nama_menu' => 'Kelas PPDB',
            'class' => 'Ppdb\KelasPpdb',
        ]);

        Menu::create([
            'parent_menu' => 8,
            'akses_role' => 1,
            'nama_menu' => 'Siswa PPDB',
            'class' => 'Ppdb\SiswaPpdb',
        ]);

        Menu::create([
            'parent_menu' => 8,
            'akses_role' => 1,
            'nama_menu' => 'Log PPDB',
            'class' => 'Ppdb\LogPpdb',
        ]);
        Menu::create([
            'parent_menu' => 8,
            'akses_role' => 1,
            'nama_menu' => 'Laporan PPDB',
            'class' => 'Ppdb\Laporan',
        ]);

    }
}
