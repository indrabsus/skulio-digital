<?php

namespace Database\Seeders;

use App\Models\JurusanPpdb;
use App\Models\MasterPpdb;
use App\Models\Setingan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetinganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setingan::create([
            'nama_instansi' => 'SMK Sangkuriang 1 Cimahi',
            'default_password' => '123456',
            'long' => 0,
            'lat' => 0
        ]);

        MasterPpdb::create([
            'daftar' => 150000,
            'ppdb' => 2350000,
            'token_telegram' => '5606244931:AAH9d-snV68vL16HkAtX4SVFb_24vF9AF6M',
            'chat_id' => '-1001818606826',
            'tahun' => 2024
        ]);

        JurusanPpdb::create([
            'nama_jurusan' => 'Akuntansi',
            'id_ppdb' => 1
        ]);
        JurusanPpdb::create([
            'nama_jurusan' => 'PPLG (Software & Game)',
            'id_ppdb' => 1
        ]);
        JurusanPpdb::create([
            'nama_jurusan' => 'Bisnis Daring Pemasaran',
            'id_ppdb' => 1
        ]);
        JurusanPpdb::create([
            'nama_jurusan' => 'MPLB (Perkantoran)',
            'id_ppdb' => 1
        ]);
    }
}
