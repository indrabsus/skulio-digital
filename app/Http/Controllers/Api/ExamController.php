<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NilaiUjian;
use App\Models\Soal;
use App\Models\Sumatif;
use App\Models\TampungSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function sumatif($id_kelas){
        $data  = Sumatif::leftJoin('mapel_kelas','mapel_kelas.id_mapelkelas','sumatif.id_mapelkelas')
        ->leftJoin('soal_ujian','soal_ujian.id_soalujian','sumatif.id_soalujian')
        ->leftJoin('mata_pelajaran','mata_pelajaran.id_mapel','mapel_kelas.id_mapel')
        ->leftJoin('kelas','kelas.id_kelas','mapel_kelas.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->where('mapel_kelas.id_kelas', $id_kelas)
        ->orderBy('sumatif.created_at', 'desc')
        ->get();

        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }

    public function cekUjian($id_sumatif, $id_user){
        $cek = NilaiUjian::where('id_sumatif', $id_sumatif)
                              ->where('id_user_siswa', $id_user)
                              ->first();
        return response()->json([
            'data' => $cek,
            'status' => 200,
            'message' => 'success'
        ]);
    }
    public function testSumatif($id_sumatif){
        $data = Sumatif::where('id_sumatif', $id_sumatif)->first();
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }
    public function tampungSoal($id_soalujian){
        $data = TampungSoal::leftJoin('soal','soal.id_soal','tampung_soal.id_soal')
        // ->leftJoin('opsi','opsi.id_soal','soal.id_soal')
        ->where('id_soalujian', $id_soalujian)->get();
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }
    public function opsiSoal($id_soal){
        $data = Soal::leftJoin('opsi','opsi.id_soal','soal.id_soal')
        ->where('soal.id_soal', $id_soal)->get()->shuffle();
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }

    public function jawabSoal(Request $request)
    {
        try {
            // Cek apakah data sudah ada
            $existingAnswer = NilaiUjian::where('id_sumatif', $request->id_sumatif)
                                        ->where('id_user_siswa', $request->id_user_siswa)
                                        ->first();

            if ($existingAnswer) {
                // Update jawaban yang sudah ada
                $existingJawaban = json_decode($existingAnswer->jawaban_siswa, true) ?? [];
                $newJawaban = $request->jawaban_siswa;

                // Gabungkan jawaban lama dan baru
                $mergedJawaban = array_merge($existingJawaban, $newJawaban);

                $existingAnswer->update([
                    'jawaban_siswa' => json_encode($mergedJawaban),
                ]);

                return response()->json([
                    'data' => $existingAnswer,
                    'status' => 200,
                    'message' => 'Jawaban berhasil diperbarui',
                ], 200);
            }

            // Simpan data baru jika belum ada
            $data = NilaiUjian::create([
                'id_sumatif' => $request->id_sumatif,
                'id_user_siswa' => $request->id_user_siswa,
                'jawaban_siswa' => json_encode($request->jawaban_siswa),
            ]);

            return response()->json([
                'data' => $data,
                'status' => 201,
                'message' => 'Jawaban berhasil disimpan',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getJawaban($id_sumatif, $id_user_siswa)
    {
        try {
            // Ambil data jawaban dari tabel jawaban sumatif
            $jawaban = NilaiUjian::where('id_sumatif', $id_sumatif)
                ->where('id_user_siswa', $id_user_siswa)
                ->first();

            if (!$jawaban) {
                return response()->json([
                    'message' => 'Jawaban tidak ditemukan',
                    'jawaban_siswa' => null,
                ], 404);
            }

            return response()->json([
                'message' => 'Jawaban berhasil diambil',
                'jawaban_siswa' => $jawaban->jawaban_siswa, // Pastikan kolom ini benar di database
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil jawaban',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function selesaiTest($id_sumatif, $id_user_siswa){
        NilaiUjian::where('id_sumatif', $id_sumatif)
        ->where('id_user_siswa', $id_user_siswa)
        ->update([
            'selesai' => true
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);
    }
}
