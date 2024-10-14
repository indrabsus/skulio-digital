<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AbsenSiswa;
use App\Models\LogSpp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhatsappController extends Controller
{
    public function cariSpp($username) {
        $siswa = User::leftJoin('data_siswa', 'data_siswa.id_user', 'users.id')
            ->leftJoin('log_spp', 'log_spp.id_siswa', 'data_siswa.id_siswa') // Gabungkan dengan log_spp jika ada
            ->where('users.username', $username)
            ->select('data_siswa.nama_lengkap', 'log_spp.keterangan', 'log_spp.nominal', 'log_spp.bayar', 'log_spp.updated_at','log_spp.status')
            ->orderBy('log_spp.updated_at', 'desc')
            ->limit(3)->get();

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

    public function kehadiran($username){
        $data = AbsenSiswa::select(
                'mata_pelajaran.nama_pelajaran',
                DB::raw("SUM(CASE WHEN absen_siswa.keterangan = 1 THEN 1 ELSE 0 END) as terlambat"),
                DB::raw("SUM(CASE WHEN absen_siswa.keterangan = 2 THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN absen_siswa.keterangan = 3 THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN absen_siswa.keterangan = 4 THEN 1 ELSE 0 END) as tanpa_keterangan")
            )
            ->leftJoin('materi','materi.id_materi','absen_siswa.id_materi')
            ->leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','materi.id_mapelkelas')
            ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','mapel_kelas.id_mapel')
            ->leftJoin('users','users.id','absen_siswa.id_user')
            ->where('users.username', $username)
            ->groupBy('mata_pelajaran.nama_pelajaran')
            ->get();

        return response()->json([
            'data' => $data,
            'message' => 'success',
            'status' => 200
        ]);
    }

}
