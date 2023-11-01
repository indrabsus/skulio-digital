<?php

namespace App\Http\Controllers;

use App\Models\Menu;
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
}
