<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Role;
use App\Models\Setingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absen as ModelsAbsen;

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
        $jarak = $this->jarak($lat1, $long1, $lat2, $long2);

        $datang = ModelsAbsen::where('id_user', $request->id_user)
            ->where('waktu', 'like', '%' . date('Y-m-d') . '%')
            ->where('status', 0) // Assuming status 0 indicates check-in
            ->count();
        $pulang = ModelsAbsen::where('id_user', $request->id_user)
            ->where('waktu', 'like', '%' . date('Y-m-d') . '%')
            ->where('status', 4) // Assuming status 4 indicates check-out
            ->count();

        if ($jarak >= 300) {
            return redirect()->route($role->nama_role . '.absen')->with('gagal', 'Diluar radius yang ditentukan! Selisih : ' . round($jarak) . ' m');
        } elseif ($datang > 0 && $request->ket == 0) {
            return redirect()->route($role->nama_role . '.absen')->with('gagal', 'Anda Sudah Absen Masuk Hari ini');
        } elseif ($pulang > 0 && $request->ket == 4) {
            return redirect()->route($role->nama_role . '.absen')->with('gagal', 'Anda Sudah Absen Pulang Hari ini');
        } elseif (date('l', strtotime(now())) == 'Sunday' || date('l', strtotime(now())) == 'Saturday') {
            return redirect()->route($role->nama_role . '.absen')->with('gagal', 'Tidak bisa Absen di hari Libur');
        } else {
            // Set status based on user role
            $status = Auth::user()->id_role == 6 ? 0 : (Auth::user()->id_role == 7 ? $request->ket : null);

            if ($status === null) {
                return redirect()->route($role->nama_role . '.absen')->with('gagal', 'Role tidak valid untuk absen');
            }

            $insert = Absen::create([
                'id_user' => $request->id_user,
                'waktu' => now(),
                'status' => $status,
            ]);

            return redirect()->route($role->nama_role . '.absen')->with('sukses', 'Berhasil Absen, Selisih: ' . round($jarak) . ' m');
        }
    }

}
