<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div wire:poll.2s class="space-y-6">
    
    <div class="flex justify-between items-end border-b border-white/10 pb-5">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Live Kitchen Display</h1>
            <p class="text-gray-400 mt-1">Orders appear here instantly. No need to refresh the page.</p>
        </div>
        
        <div class="bg-black/30 border border-orange-500/30 text-orange-400 px-4 py-2 rounded-lg flex items-center shadow-inner">
            <div class="w-2 h-2 rounded-full bg-orange-500 mr-3 animate-pulse"></div>
            <span class="font-mono font-bold text-sm">Server Time: {{ now()->format('H:i:s') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @forelse($orders as $order)
        <div class="bg-white/[0.02] border border-white/5 rounded-2xl p-6 backdrop-blur-xl border-l-4 border-l-orange-500 shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <span class="bg-orange-500/10 text-orange-400 text-xs font-bold px-3 py-1 rounded-md uppercase tracking-wider">
                    Order #{{ $order->id }}
                </span>
                <span class="text-gray-500 text-xs font-bold">{{ $order->created_at->diffForHumans() }}</span>
            </div>
            
            <h3 class="text-xl font-bold text-white mb-2">{{ $order->user->name }}</h3>
            
            <ul class="text-sm text-gray-300 space-y-2 mb-6 border-y border-white/5 py-4">
                @foreach($order->items as $item)
                <li class="flex justify-between">
                    <span>{{ $item->quantity }}x {{ $item->product->item_name }}</span> 
                    <span>Rs. {{ number_format($item->price, 2) }}</span>
                </li>
                @endforeach
            </ul>
            
            <button class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded-xl transition duration-200">
                Mark as Ready
            </button>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-gray-500 border border-dashed border-white/10 rounded-2xl">
            No pending orders in the kitchen.
        </div>
        @endforelse

    </div>
</div>