<?php

namespace App\Http\Controllers;

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
            $role = Auth::user()->level;
           
            return redirect()->route('admin.home');
            
        } else {
            return redirect()->route('loginpage')->with('gagal', 'Username dan Password Salah!');
        }      
}
}