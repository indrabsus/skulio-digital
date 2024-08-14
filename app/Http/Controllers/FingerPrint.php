<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;

class FingerPrint extends Controller
{
    public function rawlogsc(){
        $zk = new ZKTeco('192.168.107.99');
        $zk->connect();
        dd($zk->getUser());
        // $log = $zk->getAttendance();

        // // Fungsi untuk mengurutkan array berdasarkan kolom waktu secara descending
        // usort($log, function ($a, $b) {
        //     return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        // });

        // return view('fingerprint.rawlogsc', compact('log'));
    }

    public function rawlog(){
        $zk = new ZKTeco('192.168.107.99');
        $zk->connect();
        dd($zk->getAttendance());
    }
    public function insertUser($id_fp, $uid_fp, $nama, $password, $id_role, $card_no)
{
    try {
        // Inisialisasi ZKTeco
        $zk = new ZKTeco('192.168.107.99');

        // Coba koneksi ke perangkat
        if ($zk->connect()) {
            // Set user ke perangkat
            $zk->setUser($id_fp, $uid_fp, $nama, $password, $id_role, $card_no);

            // Tutup koneksi
            $zk->disconnect();

            // Redirect dengan pesan sukses
            return redirect()->back()->with('sukses', 'User berhasil ditambahkan.');
        } else {
            // Jika koneksi gagal
            return redirect()->back()->with('gagal', 'Gagal terkoneksi dengan perangkat.');
        }
    } catch (\Exception $e) {
        // Tangani kesalahan apapun dan kembalikan ke halaman sebelumnya
        return redirect()->back()->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


}
