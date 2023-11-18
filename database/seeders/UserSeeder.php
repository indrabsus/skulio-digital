<?php

namespace Database\Seeders;

use App\Models\Angkatan;
use App\Models\DataSiswa;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'id_role' => 1,
            'acc' => 'y'
        ]);

        //Dummy
        Angkatan::create([
            'tahun_masuk' => 2023
        ]);
        Jurusan::create([
            'nama_jurusan' => 'Akuntansi',
            'singkatan' => 'AK'
        ]); 
        User::create([
            'username' => 123456,
            'password' => bcrypt(123456),
            'id_role' => 5,
            'acc' => 'y'
        ]);
        Kelas::create([
            'nama_kelas' => 1,
            'id_jurusan' => 1,
            'id_user' => 2,
            'id_angkatan' => 1,
            'tingkat' => 10
        ]);
        User::create([
            'username' => '123dani',
            'password' => bcrypt(123456),
            'id_role' => 8,
            'acc' => 'y'
        ]);
        DataSiswa::create([
            'id_user' => 3,
            'id_kelas' => 1,
            'nama_lengkap' => 'Dani Setiawan',
            'jenkel' => 'l',
            'no_hp'=> '081354654533',
            'nis' => '123456'
        ]);
    }
}
