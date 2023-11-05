<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Setingan;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function routeMenu(){
        return Menu::leftJoin('roles','roles.id_role','menu.akses_role')
        ->leftJoin('parent_menu','parent_menu.id_parent','menu.parent_menu')
        ->get();
    }
    public function resetPass($id){
        $set = Setingan::where('id_setingan', 1)->first();
        User::where('id',$id)->update([
            'password'=> bcrypt($set->default_password),
        ]);
    }
}
