<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;

class FingerPrint extends Controller
{
    public function rawlogsc(){
        $zk = new ZKTeco('33.33.33.33');
        dd($zk->connect());
        $log = $zk->getAttendance();

        // Fungsi untuk mengurutkan array berdasarkan kolom waktu secara descending
        usort($log, function ($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        return view('fingerprint.rawlogsc', compact('log'));
    }

    public function rawlog(){
        return view('fingerprint.rawlog');
    }

}
