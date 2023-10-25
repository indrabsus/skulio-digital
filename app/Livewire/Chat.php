<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;

class Chat extends Component
{
    public $messages = [];
    public $newMessage = '';

    public function render()
{
    $this->messages = Message::all(); // Mengambil semua pesan dari database
    return view('livewire.chat');
}


    // Kirim pesan
public function sendMessage()
{
    // Simpan pesan ke database
    $message = Message::create([
        'user_id' => auth()->id(),
        'text' => $this->newMessage,
    ]);

    // Kirim event ke pengguna lain
    $this->dispatch('messageReceived', $message);
    
    $this->newMessage = '';
}

}
