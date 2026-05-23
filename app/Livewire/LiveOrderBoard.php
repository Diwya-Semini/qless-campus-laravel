<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LiveOrderBoard extends Component
{
    public function render()
    {
        return view('livewire.live-order-board')->layout('layouts.manager');
    }
}