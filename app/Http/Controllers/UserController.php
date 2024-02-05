<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Role;
use App\Models\Setingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function absen(){
        // $scan = Temp::first();
        return view('absengeo.absen');
    }
    public function ayoAbsen(Request $request){
        $set = Setingan::where('id_setingan', 1)->first();

        $lat1 = $request->lat;
        $long1 = $request->long;
        $lat2 = $set->lat;
        $long2 = $set->long;
        $role = Role::where('id_role', Auth::user()->id_role)->first();
        $cek = $this->cekDuplikat('absen', 'id_user', $request->id_user);
        $jarak = $this->jarak($lat1,$long1,$lat2,$long2);
    if($cek['absen']>0){
        return redirect()->route($role->nama_role.'.absen')->with('gagal', 'Anda Sudah Absen Hari ini');
        } elseif(date('l', strtotime(now())) == 'Sunday' || date('l', strtotime(now())) == 'Saturday'){
            return redirect()->route($role->nama_role.'.absen')->with('gagal', 'Tidak bisa Absen dihari Libur');
        }

        elseif($jarak >= 300){
            return redirect()->route($role->nama_role.'.absen')->with('gagal', 'Diluar radius yang ditentukan! Selisih : '.round($jarak).' m');
        }  else {
            $insert = Absen::create([
                'id_user' => $request->id_user,
                'waktu' => date('Y-m-d h:i:s'),
                'status' => 0,
            ]);
        return redirect()->route($role->nama_role.'.absen')->with('sukses', 'Berhasil Absen, Selisih: '.round($jarak).' m');
        }
    }
}
