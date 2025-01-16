<?php

namespace App\Imports;

use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    protected $id_kelas;

    public function __construct($id_kelas)
    {
        $this->id_kelas = $id_kelas;
    }

    public function model(array $row)
    {
        return DB::transaction(function() use ($row) {
            $username = substr(rand(100, 999) . strtolower(str_replace(' ', '', $row['nama_lengkap'])),0,10);

            // Check for existing records in data_siswa and users tables
            $userExists = User::where('username', $username)->exists();
            $dataSiswaExists = DataSiswa::where('nis', $row['nis'])
                ->orWhere('no_hp', $row['no_hp'])
                ->exists();

            if (!$userExists && !$dataSiswaExists) {
                // Insert into users table
                $user = User::create([
                    'username' => $username,
                    'password' => bcrypt(123456),
                    'id_role' => 8,
                    'acc' => 'y',
                ]);

                // Insert into data_siswa table
                DataSiswa::create([
                    'id_user' => $user->id,
                    'id_kelas' => $this->id_kelas,
                    'nama_lengkap' => $row['nama_lengkap'],
                    'jenkel' => $row['jenkel'],
                    'no_hp' => $row['no_hp'],
                    'nis' => $row['nis'],
                    'no_rfid' => '',
                    // Tambahkan field lain sesuai kebutuhan
                ]);

                return $user;
            }

            // Return null if the record already exists, no need to insert
            return null;
        });
    }
}
