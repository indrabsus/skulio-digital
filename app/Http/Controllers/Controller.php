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
}
