<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function hapusNilai($id){
        Nilai::where('id', $id)->delete();
        return redirect()->route('guru.siswakelas')->with('sukses', 'Data berhasil dihapus!');
    }
}
