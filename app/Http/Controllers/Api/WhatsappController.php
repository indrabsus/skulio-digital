<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogSpp;
use App\Models\User;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function cariSpp($username) {
        $siswa = User::leftJoin('data_siswa', 'data_siswa.id_user', 'users.id')
            ->leftJoin('log_spp', 'log_spp.id_siswa', 'data_siswa.id_siswa') // Gabungkan dengan log_spp jika ada
            ->where('users.username', $username)
            ->select('data_siswa.nama_lengkap', 'log_spp.keterangan', 'log_spp.nominal', 'log_spp.bayar', 'log_spp.updated_at','log_spp.status')
            ->first();

        // Cek jika data siswa ada
        if ($siswa) {
            return response()->json([
                'data' => $siswa,
                'message' => 'success',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'status' => 404
            ]);
        }
    }

}
