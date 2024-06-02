<?php

namespace App\Http\Controllers;

use App\Models\Cigalert as ModelsCigalert;
use Illuminate\Http\Request;

class Cigalert extends Controller
{
    public function postSensor($nama_mesin, $value){
        $data = ModelsCigalert::create([
            'nama_mesin' => $nama_mesin,
            'value' => $value
        ]);
        return 'sukses';
    }
}
