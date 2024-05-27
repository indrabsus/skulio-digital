<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function isiContoh(){
        Kegiatan::create([
            'judul' => 'Skulio Digital',
            'deskripsi' => 'Ini adalah contoh saja woiiii',
            'gambar' => 'https://flowbite.com/docs/images/blog/image-1.jpg'
        ]);
    }

    public function viewKegiatan(){
        $data = Kegiatan::all();
        return response()->json([
            'data' => $data,
            'status' => 200,
        ]);
    }
}
