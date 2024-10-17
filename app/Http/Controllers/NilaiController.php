<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function hapusNilai($id){
        Nilai::where('id', $id)->delete();
        return redirect()->route('guru.siswakelas')->with('sukses', 'Data berhasil dihapus!');
    }

    public function postNilai(Request $request) {
        // Ambil semua input 'nilai' dan 'id_materi'
        $nilaiArray = $request->input('nilai');
        $idUserArray = $request->input('id_user');
        $idMateriArray = $request->input('id_materi');

        if (is_array($nilaiArray) && is_array($idUserArray) && is_array($idMateriArray)) {
            foreach ($nilaiArray as $id_user => $nilai) {
                // Pastikan 'id_materi' ada untuk setiap 'id_user'
                if (isset($idMateriArray[$id_user])) {
                    $id_materi = $idMateriArray[$id_user];

                    // Update atau buat data baru di tabel `nilai`
                    Nilai::updateOrCreate(
                        [
                            'id_user' => $id_user,
                            'id_materi' => $id_materi,
                        ],
                        [
                            'nilai' => $nilai
                        ]
                    );
                }
            }
        }

        return back()->with('sukses', 'Nilai berhasil disimpan!');
    }

}
