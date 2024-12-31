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
            if($user->acc == 'n'){
                return response()->json([
                    'data' => [],
                    'status' => 401,
                    'message' => 'Akun belum di Konfirmasi Admin'
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

    public function allGuru(){
        $data = ModelsUser::leftJoin('data_user', 'data_user.id_user', '=', 'users.id')
        ->leftJoin('roles','roles.id_role','users.id_role')
        ->where('users.id_role', 6)
        ->select('users.*', 'data_user.*', 'roles.*') // Pilih kolom yang diperlukan
        ->paginate(10);
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }

    public function dataGuru($id){
        $data = ModelsUser::leftJoin('data_user', 'data_user.id_user', '=', 'users.id')
        ->leftJoin('roles','roles.id_role','users.id_role')
        ->where('users.id_role', 6)
        ->where('users.id', $id)
        ->select('users.*', 'data_user.*', 'roles.*') // Pilih kolom yang diperlukan
        ->first();
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }
    public function allSiswa(){
        $data = ModelsUser::leftJoin('data_siswa', 'data_siswa.id_user', '=', 'users.id')
        ->leftJoin('roles','roles.id_role','users.id_role')
        ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->where('users.id_role', 8)
        ->select('users.*', 'data_siswa.*', 'roles.*', 'kelas.*') // Pilih kolom yang diperlukan
        ->get();
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }
    public function dataSiswa($id){
        $data = ModelsUser::leftJoin('data_siswa', 'data_siswa.id_user', '=', 'users.id')
        ->leftJoin('roles','roles.id_role','users.id_role')
        ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->where('users.id_role', 8)
        ->where('users.id', $id)
        ->select('users.*', 'data_siswa.*', 'roles.*','kelas.*','jurusan.*') // Pilih kolom yang diperlukan
        ->first();
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }


    public function daftarPpdb(Request $request)
    {
        try {
            // Validasi data dengan pesan error dalam bahasa Indonesia
            $validatedData = $request->validate([
                'nisn' => 'required|unique:siswa_ppdb|numeric',
                'nama_lengkap' => 'required',
                'jenkel' => 'required',
                'asal_sekolah' => 'required',
                'nohp' => 'required|numeric',
                'tanggal_lahir' => 'required|date',
                'agama' => 'required',
                'ayah' => 'required',
                'nik_siswa' => 'required|numeric|unique:siswa_ppdb',
                'ibu' => 'required',
                'tempat_lahir' => 'required',
                'alamat' => 'required',
                'minat_jurusan1' => 'required',
                'minat_jurusan2' => 'required',
            ],[
                'required' => ':attribute wajib diisi.',
    'unique' => ':attribute sudah dipakai.',
    'numeric' => ':attribute harus berupa angka.',
    'date' => ':attribute harus berupa tanggal yang valid.',
    'attributes' => [
        'nisn' => 'NISN',
        'nama_lengkap' => 'Nama Lengkap',
        'jenkel' => 'Jenis Kelamin',
        'asal_sekolah' => 'Asal Sekolah',
        'nohp' => 'Nomor HP',
        'tanggal_lahir' => 'Tanggal Lahir',
        'agama' => 'Agama',
        'ayah' => 'Nama Ayah',
        'ibu' => 'Nama Ibu',
        'tempat_lahir' => 'Tempat Lahir',
        'alamat' => 'Alamat',
        'nik_siswa' => 'NIK Siswa',
        'minat_jurusan1' => 'Minat Jurusan 1',
        'minat_jurusan2' => 'Minat Jurusan 2',
    ],
            ]);

            // Data siswa yang akan disimpan
            $siswa = [
                'nisn' => $validatedData['nisn'],
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'nik_siswa' => $validatedData['nik_siswa'],
                'jenkel' => $validatedData['jenkel'],
                'asal_sekolah' => $validatedData['asal_sekolah'],
                'minat_jurusan1' => $validatedData['minat_jurusan1'],
                'minat_jurusan2' => $validatedData['minat_jurusan2'],
                'no_hp' => $validatedData['nohp'],
                'tempat_lahir' => $validatedData['tempat_lahir'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'alamat' => $validatedData['alamat'],
                'agama' => $validatedData['agama'],
                'nama_ayah' => $validatedData['ayah'],
                'nama_ibu' => $validatedData['ibu'],
                'bayar_daftar' => 'n'
            ];

            // Ambil data konfigurasi Telegram
            $set = MasterPpdb::where('tahun', date('Y'))->first();

            // Simpan data siswa ke database
            $input = SiswaPpdb::create($siswa);

            // Kirim notifikasi Telegram
            $teks = 'Pemberitahuan, ada siswa baru mendaftar dengan nama ' . $validatedData['nama_lengkap'] .
                ', dan asal sekolah dari ' . $validatedData['asal_sekolah'] .
                ', no Whatsapp : https://wa.me/62' . substr($validatedData['nohp'], 1);

            $response = Http::get('https://api.telegram.org/bot' . $set->token_telegram . '/sendMessage?chat_id=' . $set->chat_id . '&text=' . urlencode($teks));

            // Periksa apakah notifikasi berhasil
            if ($response->successful()) {
                return response()->json([
                    'data' => $input,
                    'status' => 200,
                    'message' => 'success'
                ]);
            } else {
                return response()->json([
                    'data' => [],
                    'status' => 500,
                    'message' => 'Telegram notification failed'
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            return response()->json([
                'errors' => $e->errors(),
                'status' => 422,
                'message' => 'Validasi gagal'
            ]);
        } catch (\Exception $e) {
            // Tangani error lain
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 500,
                'message' => 'Terjadi kesalahan tak terduga'
            ]);
        }
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
