<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

#[Layout('layouts.manager')]
class LiveOrderBoard extends Component
{
    public function render()
    {
        $manager = Auth::user();
        
        // Fetch real, pending orders for THIS specific manager's canteen!
        $orders = Order::with(['user', 'items.product'])
                       ->where('canteen_id', $manager->canteen_id)
                       ->where('status', 'pending')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('livewire.live-order-board', compact('orders'));
    }
}