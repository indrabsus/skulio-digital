<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\MapelKelas;
use App\Models\Materi;
use Illuminate\Http\Request;

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

}
