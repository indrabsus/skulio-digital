<?php

namespace App\Livewire\Admin;

use App\Models\Jurusan;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $data  = Jurusan::all();
        return view('livewire.admin.dashboard', compact('data'));
    }
}
