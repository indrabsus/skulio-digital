<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Setingan;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function routeMenu(){
        if (!Schema::hasTable('menu')) {
           $menu = [];
           return $menu;
        } else {
            return Menu::leftJoin('roles', 'roles.id_role', 'menu.akses_role')
            ->leftJoin('parent_menu', 'parent_menu.id_parent', 'menu.parent_menu')
            ->get();
        }
    }
    public function resetPass($id){
        $set = Setingan::where('id_setingan', 1)->first();
        User::where('id',$id)->update([
            'password'=> bcrypt($set->default_password),
        ]);
    }
    public function changePassword($id,$pass){
        $ganti = User::where('id',$id)->update([
            'password' => bcrypt($pass)
        ]);
        return $ganti;
    }

    public function jarak($lat1,$long1,$lat2,$long2){
        $theta = $long1 - $long2;
        $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $result['miles'] = $miles * 60 * 1.1515;
        $result['feet'] = $result['miles']*5280;
        $result['yards'] = $result['feet']/3;
        $result['kilometers'] = $result['miles']*1.609344;
        $result['meters'] = $result['kilometers']*1000;

        return $result['meters'];
        }

        public function cekDuplikat($table, $key, $value){
            $hitung['absen'] = DB::table($table)->where($key, $value)->where('waktu', 'like','%'.date('Y-m-d').'%')->count();
            return $hitung;
        }

        public function hari($hari)
{
    // Daftar hari
    $days = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];

    // Jika $hari adalah null, '', atau array kosong, kembalikan 'Unknown'
    if (is_null($hari) || $hari === '' || (is_array($hari) && empty($hari))) {
        return '';
    }

    // Pastikan $hari adalah array
    if (is_string($hari)) {
        // Jika string, konversi menjadi array dengan memisahkan berdasarkan koma
        $hari = array_map('trim', explode(',', $hari));
    } elseif (!is_array($hari)) {
        // Jika $hari bukan array dan bukan string, kembalikan 'Unknown'
        return '';
    }

    // Pastikan $hari adalah array dan tidak kosong
    if (is_array($hari)) {
        // Filter dan map hari-hari yang sesuai
        $validDays = array_filter($hari, function($h) use ($days) {
            return isset($days[(int)$h]); // Hanya masukkan hari yang ada di array $days
        });

        // Mengembalikan daftar hari yang valid, dipisahkan oleh koma
        return implode(', ', array_map(function($h) use ($days) {
            return $days[(int)$h];
        }, $validDays));
    }

    // Jika bukan array atau string yang valid, kembalikan 'Unknown'
    return '';
}

public function statusBos($id){
    if($id == 1){
        return 'Disetujui';
    }elseif($id == 2){
        return 'Realisasi';
    }elseif($id == 3){
        return 'Distribusi';
    }
}
}
