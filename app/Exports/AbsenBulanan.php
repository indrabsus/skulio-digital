<?php

namespace App\Exports;

use App\Models\Absen;
use App\Models\DataUser;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbsenBulanan implements FromView
{
    public $bln, $jbtn;
    public function __construct($bln, $jbtn)
    {
        $this->bln = $bln;
        $this->jbtn = $jbtn;
    }

    public function view(): View
    {
        return view('xls.absenbulanan', [
            'data' => DataUser::orderBy('id','asc')
            ->leftJoin('users','users.id','=','data_user.id_user')
            ->leftJoin('roles','roles.id_role','=','users.id_role')
            ->where('users.id_role',$this->jbtn)
            ->get(),
            'bulan' => $this->bln,
            'role' => $this->jbtn
        ]);
    }
}
