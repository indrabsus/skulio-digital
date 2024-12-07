<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterPpdb;
use App\Models\SiswaPpdb;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class User extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = ModelsUser::leftJoin('roles','roles.id_role','users.id_role')
        ->where('username', $request->username)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'data' => [],
                'status' => 401,
                'message' => 'Invalid username or password'
            ]);
        } else {
            $token = $user->createToken($request->username)->plainTextToken;
            return response()->json([
                'data' => [
                    'token' => $token,
                    'data' => $user
                ],
                'status' => 200,
                'message' => 'success'
            ]);
        }


    }

    public function logout(){
        Auth::user()->tokens()->delete();
        return response()->json([
            'data' => [],
            'status' => 200,
            'message' => 'success'
        ]);
    }
    public function userData(){
        $data = ModelsUser::all();
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }

    public function dataGuru($id){
        $data = ModelsUser::leftJoin('data_user', 'data_user.id_user', '=', 'users.id')
        ->where('users.id_role', 6)
        ->where('users.id', $id)
        ->select('users.*', 'data_user.*') // Pilih kolom yang diperlukan
        ->first();
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }
    public function dataSiswa($id){
        $data = ModelsUser::leftJoin('data_siswa', 'data_siswa.id_user', '=', 'users.id')
        ->where('users.id_role', 8)
        ->where('users.id', $id)
        ->select('users.*', 'data_siswa.*') // Pilih kolom yang diperlukan
        ->first();
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }

    public function daftarPpdb(Request $request){
        $request->validate([
            'nisn' => 'required|unique:siswa_ppdb|numeric',
            'nama_lengkap' => 'required',
            'jenkel' => 'required',
            'asal_sekolah' => 'required',
            'nohp' => 'required|numeric',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
            'ayah' => 'required',
            'nik_siswa' => 'required',
            'ibu' => 'required',
            'tempat_lahir' => 'required',
            'alamat' => 'required',
            'minat_jurusan1' => 'required',
            'minat_jurusan2' => 'required',

        ]);

        $siswa = [
            'nisn' => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'nik_siswa' => $request->nik_siswa,
            'jenkel' => $request->jenkel,
            'asal_sekolah' => $request->asal_sekolah,
            'minat_jurusan1' => $request->minat_jurusan1,
            'minat_jurusan2' => $request->minat_jurusan2,
            'no_hp' => $request->nohp,
            'tempat_lahir' => "$request->tempat_lahir",
            'tanggal_lahir' => "$request->tanggal_lahir",
            'alamat' => $request->alamat,
            'agama' => $request->agama,
            'nama_ayah' => $request->ayah,
            'nama_ibu' => $request->ibu,
            'bayar_daftar' => 'n'
        ];
        $set = MasterPpdb::where('tahun', date('Y'))->first();
        $input = SiswaPpdb::create($siswa);
        $teks = 'Pemberitahuan, ada siswa baru mendaftar dengan nama ' . $request->nama_lengkap . ', dan asal sekolah dari ' . $request->asal_sekolah . ', no Whatsapp : https://wa.me/62'. substr($request->nohp, 1);
        $response = Http::get('https://api.telegram.org/bot'.$set->token_telegram.'/sendMessage?chat_id='.$set->chat_id.',&text='.$teks);

        return response()->json([
            'data' => $input,
            'status' => 200,
            'message' => 'success'
        ]);
    }

    public function cariGuru(Request $request)
{

    // Mengambil data guru dari database
    $guru = ModelsUser::leftJoin('data_user', 'data_user.id_user', '=', 'users.id')
                ->where('users.id_role', 6)
                ->where('users.username', $request->username)
                ->select('users.*', 'data_user.*') // Pilih kolom yang diperlukan
                ->first();

    // Cek apakah guru ditemukan
    if ($guru) {
        return response()->json([
            'data' => $guru,
            'status' => 200,
            'message' => 'Guru ditemukan.',
        ], 200);
    } else {
        return response()->json([
            'data' => null,
            'status' => 404,
            'message' => 'Guru tidak ditemukan.',
        ], 404);
    }
}

}
