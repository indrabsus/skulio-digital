<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginpage(){
        return view('login');
    }
    public function login(Request $request){
        $auth = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($auth)){
            $auth = Auth::user();
            $data = Role::where('id_role', Auth::user()->id_role)->first();
            $role = $data->nama_role;

            return redirect()->route($role.'.dashboard');

        } else {
            return redirect()->route('loginpage')->with('gagal', 'Username dan Password Salah!');
        }
}
public function logout(){
    Auth::logout();
    return redirect()->route('loginpage');
}
}
