<?php

namespace Database\Seeders;

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
    }
}
