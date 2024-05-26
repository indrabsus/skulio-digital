<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\Temp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RFIDController extends Controller
{
    public function inputscan(){
        $id_mesin = Session::get("kode_mesin");
        $neww = Temp::where('id_mesin', $id_mesin)->orderBy('created_at','desc')->first();
    if($neww){
        $print = $neww->norfid;
    } else {
        $print = '';
    }

    return view('load.inputscan', [
        'scan' => $print
    ]);
    }
    public function insertuser(Request $request){
        $request->validate([
            'no_rfid' => 'required',
            'id_user' => 'required',
            'kode_mesin' => 'required',
        ]);
        $hitung = DataUser::where('no_rfid',$request->no_rfid)->count();
        if($hitung > 0){
            return redirect()->route('admin.datakaryawan')->with('gagal', 'Kartu sudah ada');
        } else {
            $update = DataUser::where('id_user', $request->id_user)->update([
                'no_rfid' => $request->no_rfid
            ]);
            if($update){
                Temp::where('id_mesin', $request->kode_mesin)->delete();
                return redirect()->route('admin.datakaryawan')->with('sukses', 'Berhasilkan menambahkan kartu');
            } else {
                return redirect()->route('admin.datakaryawan')->with('gagal', 'Gagal menambahkan kartu');
            }
        }
    }

    public function rfidglobal($norfid, $id_mesin){
        $simpan = Temp::create(['norfid' => $norfid, 'id_mesin' => $id_mesin]);
        if($simpan){
            echo "Berhasil";
        } else {
            echo "Gagal";
        }
    }
}
