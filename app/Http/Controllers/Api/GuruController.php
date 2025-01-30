<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\AbsenSiswa;
use App\Models\MapelKelas;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function isiAgenda($username){
        $currentDay = date('N');
        $data  = MapelKelas::leftJoin('mata_pelajaran', 'mata_pelajaran.id_mapel', '=', 'mapel_kelas.id_mapel')
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'mapel_kelas.id_kelas')
            ->leftJoin('jurusan', 'jurusan.id_jurusan', '=', 'kelas.id_jurusan')
            ->leftJoin('data_user', 'data_user.id_user', '=', 'mapel_kelas.id_user')
            ->leftJoin('users', 'users.id', '=', 'mapel_kelas.id_user')
            ->whereRaw("FIND_IN_SET(?, hari) > 0", [$currentDay])
            ->where('users.username', $username)
            ->get();
        if($data->count() > 0){
            return response()->json([
                'data' => $data,
                'status' => 200
            ]);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }
    public function prosesAgenda($materi, $tingkat, $id_mapelkelas){
        // $semester='ganjil';
        $currentMonth = now()->month;

        if (in_array($currentMonth, [7, 8, 9, 10, 11, 12])) {
            $semester = 'ganjil';
        } else {
            $semester = 'genap';
        }
        $hitung = Materi::where('id_mapelkelas', $id_mapelkelas)
        ->whereDate('created_at', now()->format('Y-m-d'))->count();
        if($hitung > 0){
            $data = Materi::where('id_mapelkelas', $id_mapelkelas)
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->update([
                'materi' => $materi
            ]) ;
        } else {
            $data = Materi::create([
                'id_mapelkelas' => $id_mapelkelas,
                'materi' => $materi,
                'semester' => $semester,
                'penilaian' => 'n',
                'tingkatan' => $tingkat
            ]) ;

        }
        return response()->json(['message' => 'Data berhasil ditambahkan'], 200);
    }

    public function absenWa($username){
        $abs = Materi::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','=','materi.id_mapelkelas')
        ->leftJoin('users','users.id','=','mapel_kelas.id_user')
        ->where('users.username', $username)
        ->whereDate('materi.created_at', now()->format('Y-m-d'))->get();

        return response()->json([
            'data' => $abs,
            'status' => 200
        ]);
    }

    public function absenListSiswa($id_materi){
        $data  = Materi::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','=','materi.id_mapelkelas')
        ->leftJoin('kelas','kelas.id_kelas','=','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','=','kelas.id_jurusan')
        ->leftJoin('data_siswa','data_siswa.id_kelas','=','kelas.id_kelas')
        ->leftJoin('users','users.id','=','data_siswa.id_user')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','=','mapel_kelas.id_mapel')
        ->where('users.acc', 'y')
        ->where('materi.id_materi', $id_materi)
        ->orderBy('nama_lengkap','asc')
        ->select('nama_lengkap','tingkat','singkatan','nama_kelas','materi','materi.created_at AS waktu_agenda','materi.id_materi','data_siswa.id_user','penilaian')
        ->get();

        return response()->json([
            'data' => $data,
            'status' => 200
        ]);
    }
    public function prosesAbsen($id_user, $id_materi, $waktu_agenda, $keterangan)
{
    $existingData = AbsenSiswa::where([
        'id_materi' => $id_materi,
        'id_user' => $id_user,
        'waktu' => $waktu_agenda
    ])->first();

    if ($existingData) {
        // Update hanya jika keterangan berbeda
        if ($existingData->keterangan !== $keterangan) {
            $existingData->update(['keterangan' => $keterangan]);
        }
        $data = $existingData; // Tetapkan data yang ada
    } else {
        // Create data baru
        $data = AbsenSiswa::create([
            'id_materi' => $id_materi,
            'id_user' => $id_user,
            'waktu' => $waktu_agenda,
            'keterangan' => $keterangan
        ]);
    }

    return response()->json([
        'data' => $data,
        'status' => 200
    ]);
}


    public function cekUsername($username){
        $data = User::where('username', $username)
        ->where('id_role', 6)
        ->first();
        if($data){
            return response()->json([
                'data' => $data,
                'status' => 200
            ]);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }
}
