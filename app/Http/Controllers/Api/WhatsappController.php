<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogSpp;
use App\Models\User;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function sppCek($username)
{
    $cek = User::where('username', $username)->first();
    // Cari siswa berdasarkan username
    $siswa = LogSpp::leftJoin('data_siswa', 'data_siswa.id_siswa', '=', 'log_spp.id_siswa')
        ->leftJoin('users', 'users.id', '=', 'data_siswa.id_user')
        ->where('users.username', $username)
        ->get();
    $count = LogSpp::leftJoin('data_siswa', 'data_siswa.id_siswa', '=', 'log_spp.id_siswa')
        ->leftJoin('users', 'users.id', '=', 'data_siswa.id_user')
        ->where('users.username', $username)
        ->count();

if(!$cek){
    return response()->json(['message' => 'username tidak ditemukan'], 404);
} else if ($count < 1) {
    return response()->json(['message' => 'Belum ada pembayaran'], 404);
} else if ($count > 0) {
    return response()->json($siswa);
}

}
}
