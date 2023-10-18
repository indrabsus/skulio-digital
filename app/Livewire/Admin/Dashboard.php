<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    { 
        $title = 'Dashboard Admin';
        return view('livewire.admin.dashboard', compact('title'));
    }
}
