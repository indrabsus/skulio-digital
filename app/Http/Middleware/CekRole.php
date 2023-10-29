<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $data = Role::where('id_role', Auth::user()->id_role)->first();
        if($data->nama_role == $role){
            return $next($request);
        }
        return redirect()->route('loginpage')->with('status', 'Anda tidak punya akses');

    }
}
