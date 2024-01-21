<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;

class FingerPrint extends Controller
{
    public function user(){
        $zk = new ZKTeco('192.168.30.33');
        $zk->connect();
        $data = $zk->getUser();
        $log = $zk->getAttendance();
        dd($data);

        return view('absen', compact('data'));
    }
    public function insertUser(){
        $zk = new ZKTeco('192.168.30.33');
        $zk->connect();
        $zk->setUser(1002,1002,'Batara','',2,0);
    }
    public function rawlogsc(){
        $zk = new ZKTeco('192.168.30.33');
        $zk->connect();
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
    public function clear(){
        $zk = new ZKTeco('192.168.30.33');
        $zk->connect();
        $zk->clearAttendance();
    }
}
