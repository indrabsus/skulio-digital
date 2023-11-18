<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginpage(){
        return view('login');
    }
    public function registerpage(){
        $kelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')->get();
        return view('register', compact('kelas'));
    }
    public function register(Request $request){
        $auth = $request->validate([
            'username' => 'required',
            'no_hp' => 'required',
            'nama_lengkap' => 'required',
            'jenkel' => 'required',
            'id_kelas' => 'required',
            'nis' => 'required',
        ]);
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->nis),
            'id_role' => 8,
            'acc' => 'n',
        ]);
        DataSiswa::create([
            'id_user' => $user->id,
            'nama_lengkap' => ucwords($request->nama_lengkap),
            'jenkel' => $request->jenkel,
            'no_hp' => $request->no_hp,
            'nis' => $request->nis,
            'id_kelas' => $request->id_kelas,
        ]);
        return redirect()->route('loginpage')->with('sukses','Pendaftaran berhasil, silakan tunggu ACC Admin untuk login!');
    }
    public function login(Request $request){
        $auth = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($auth)){
            if(Auth::user()->acc == 'n'){
                Auth::logout();
    return redirect()->route('loginpage')->with('gagal','Akun anda belum diaktifkan oleh Admin!');
            } else {
                $data = Role::where('id_role', Auth::user()->id_role)->first();
                $role = $data->nama_role;

                return redirect()->route('dashboard');
            }


        } else {
            return redirect()->route('loginpage')->with('gagal', 'Username dan Password Salah!');
        }
}
public function logout(){
    Auth::logout();
    return redirect()->route('loginpage');
}
}
