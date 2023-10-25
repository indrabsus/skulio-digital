<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function fetchNewMessages()
{
    // Ambil pesan-pesan baru dari database atau sumber data lainnya
    $newMessages = Message::all();

    // Kembalikan pesan-pesan dalam format yang sesuai (misalnya, dalam bentuk HTML atau JSON)
    return view('chat.new_messages', ['newMessages' => $newMessages]);

    // Jika menggunakan JSON:
    // return response()->json(['newMessages' => $newMessages]);
}

}
