<?php

namespace App\Http\Controllers;

use App\Models\Cigalert as ModelsCigalert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Cigalert extends Controller
{
    public function postSensor($nama_mesin, $value){
        $data = ModelsCigalert::create([
            'nama_mesin' => $nama_mesin,
            'value' => $value
        ]);
        $text = "Terdeteksi dengan kandungan Co2 sebesar " . urlencode($value)." "."dikode alat ". urlencode($nama_mesin);
    $url = 'https://api.telegram.org/bot5417045102:AAG2PxP4kstpmUIOsjByKHsnivIOnECn_20/sendMessage?chat_id=1519611910&text=' . $text;
        Http::get($url);
    }
}
