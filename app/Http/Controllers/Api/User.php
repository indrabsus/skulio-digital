<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = ModelsUser::leftJoin('roles','roles.id_role','users.id_role')
        ->where('username', $request->username)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'data' => [],
                'status' => 401,
                'message' => 'Invalid username or password'
            ]);
        } else {
            $token = $user->createToken($request->username)->plainTextToken;
            return response()->json([
                'data' => [
                    'token' => $token,
                    'data' => $user
                ],
                'status' => 200,
                'message' => 'success'
            ]);
        }


    }

    public function logout(){
        Auth::user()->tokens()->delete();
        return response()->json([
            'data' => [],
            'status' => 200,
            'message' => 'success'
        ]);
    }
    public function userData(){
        $data = ModelsUser::all();
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
        ]);
    }
}
