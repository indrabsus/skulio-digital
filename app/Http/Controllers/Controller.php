<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Setingan;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
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
}
