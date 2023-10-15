<?php

namespace Database\Seeders;

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
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);
        User::create([
            'nama' => 'Petugas',
            'username' => 'petugas',
            'password' => bcrypt('petugas'),
            'role' => 'petugas'
        ]);
        User::create([
            'nama' => 'Member',
            'username' => 'member',
            'password' => bcrypt('member'),
            'role' => 'member'
        ]);
    }
}
