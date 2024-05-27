<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\DataUser;
use App\Models\LogTabungan;
use App\Models\Temp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function topup(){

        $neww = Temp::where('id_mesin', Session::get("kode_mesin"))->orderBy('created_at', 'desc')->first();
        // dd($neww);
        $saldo = 0;
        if($neww){
            $data = DataSiswa::where('no_rfid', $neww->norfid)->first();


            $print = $data->no_rfid;
            $id_siswa = $data->id_siswa;
            $nama = $data->nama_lengkap;
            $masuk = LogTabungan::where('id_siswa', $data->id_siswa)->where('jenis','kd')->sum('nominal');
            $keluar = LogTabungan::where('id_siswa', $data->id_siswa)->where('jenis','db')->sum('nominal');

            $saldo = $masuk - $keluar;

            $noref = 'TO'.date('dmyh').substr($data->id_user, 0, 5);

        } else {
            $print = '';
            $id_siswa = '';
            $nama = '';
            $saldo = '';
            $noref = '';
        }

        return view('load.topupinput', [
            'scan' => $print,
            'nama' => $nama,
            'saldo' => $saldo,
            'noref' => $noref,
            'id_siswa' => $id_siswa
        ]);
    }
    public function payment(){

        $neww = Temp::where('id_mesin', Session::get("kode_mesin"))->orderBy('created_at', 'desc')->first();
        // dd($neww);
        $saldo = 0;
        if($neww){
            $data = DataSiswa::where('no_rfid', $neww->norfid)->first();


            $print = $data->no_rfid;
            $id_siswa = $data->id_siswa;
            $nama = $data->nama_lengkap;
            $masuk = LogTabungan::where('id_siswa', $data->id_siswa)->where('jenis','kd')->sum('nominal');
            $keluar = LogTabungan::where('id_siswa', $data->id_siswa)->where('jenis','db')->sum('nominal');

            $saldo = $masuk - $keluar;

            $noref = 'PO'.date('dmyh').substr($data->id_user, 0, 5);

        } else {
            $print = '';
            $id_siswa = '';
            $nama = '';
            $saldo = '';
            $noref = '';
        }

        return view('load.paymentinput', [
            'scan' => $print,
            'nama' => $nama,
            'saldo' => $saldo,
            'noref' => $noref,
            'id_siswa' => $id_siswa
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
            Temp::where('id_mesin', $request->kode_mesin)->delete();
            return redirect()->route('admin.datakaryawan')->with('gagal', 'Kartu sudah ada');
        } else {
            $update = DataUser::where('id_user', $request->id_user)->update([
                'no_rfid' => $request->no_rfid
            ]);
            if($update){
                Temp::where('id_mesin', $request->kode_mesin)->delete();
                return redirect()->route('admin.datakaryawan')->with('sukses', 'Berhasilkan menambahkan kartu');
            } else {
                Temp::where('id_mesin', $request->kode_mesin)->delete();
                return redirect()->route('admin.datakaryawan')->with('gagal', 'Gagal menambahkan kartu');
            }
        }
    }
    public function insertsiswa(Request $request){
        $request->validate([
            'no_rfid' => 'required',
            'id_user' => 'required',
            'kode_mesin' => 'required',
        ]);
        $hitung = DataSiswa::where('no_rfid',$request->no_rfid)->count();
        if($hitung > 0){
            Temp::where('id_mesin', $request->kode_mesin)->delete();
            return redirect()->route('admin.datasiswa')->with('gagal', 'Kartu Sudah Digunakan');
        } else {
            $update = DataSiswa::where('id_user', $request->id_user)->update([
                'no_rfid' => $request->no_rfid
            ]);
            if($update){
                Temp::where('id_mesin', $request->kode_mesin)->delete();
                return redirect()->route('admin.datasiswa')->with('sukses', 'Berhasil update data!');
            } else {
                Temp::where('id_mesin', $request->kode_mesin)->delete();
                return redirect()->route('admin.datasiswa')->with('gagal', 'Gagal menambahkan kartu!');
            }
        }
    }

    public function topupProses(Request $request){
        // dd($request->all());
        $duplikat = LogTabungan::where('no_invoice', $request->no_ref)->count();
        $request->validate([
            'saldo' => 'required',
        ]);
        if($duplikat > 0){
            Temp::where('id_mesin', Session::get('kode_mesin'))->delete();
            return redirect()->back()->with('gagal', 'Tunggu sebentar lagi!');
        } else {
            $user = DataSiswa::where('no_rfid', $request->no_rfid)->first();
       LogTabungan::create([
            'id_siswa' => $user->id_siswa,
            'jenis' => 'kd',
            'no_invoice' => $request->no_ref,
            'nominal' => $request->saldo,
            'id_petugas' => Auth::user()->id,
            'log' => 'Top Up Saldo Via Kartu RFID sebesar Rp.'.number_format($request->nominal,0,",",".")
        ]);
        Temp::where('id_mesin', Session::get('kode_mesin'))->delete();
        return redirect()->back()->with('sukses', 'Berhasil Update Saldo');

        }
    }
    public function paymentProses(Request $request){

        // dd($request->all());
        $duplikat = LogTabungan::where('no_invoice', $request->no_ref)->count();
        $request->validate([
            'saldo' => 'required',
        ]);
        $neww = Temp::where('id_mesin', Session::get("kode_mesin"))->orderBy('created_at', 'desc')->first();
        $saldo = 0;
        $data = DataSiswa::where('no_rfid', $neww->norfid)->first();
        $masuk = LogTabungan::where('id_siswa', $data->id_siswa)->where('jenis','kd')->sum('nominal');
        $keluar = LogTabungan::where('id_siswa', $data->id_siswa)->where('jenis','db')->sum('nominal');

        $saldo = $masuk - $keluar;

        if($duplikat > 0){
            Temp::where('id_mesin', Session::get('kode_mesin'))->delete();
            return redirect()->back()->with('gagal', 'Tunggu sebentar lagi!');
        } else {
            if($request->saldo > $saldo){
                return redirect()->back()->with('gagal', 'Saldo tidak cukup!');
            } else {
                $user = DataSiswa::where('no_rfid', $request->no_rfid)->first();
       LogTabungan::create([
            'id_siswa' => $user->id_siswa,
            'jenis' => 'db',
            'no_invoice' => $request->no_ref,
            'nominal' => $request->saldo,
            'id_petugas' => Auth::user()->id,
            'log' => 'Tarik/Bayar Saldo Via Kartu RFID sebesar Rp.'.number_format($request->nominal,0,",",".")
        ]);
        Temp::where('id_mesin', Session::get('kode_mesin'))->delete();
        return redirect()->back()->with('sukses', 'Berhasil Update Saldo');
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
