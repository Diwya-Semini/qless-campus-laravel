@extends('layouts.student')

@section('content')
    
    <h1 class="text-3xl font-black text-white mb-8">Your Tray</h1>

    @php 
        $cart = session('cart', []); 
        $total = 0; 
    @endphp

    @if(empty($cart))
        <div class="text-center text-gray-500 py-16 bg-[#16161a] rounded-3xl border border-gray-800">
            <p class="text-xl mb-4">Your tray is completely empty.</p>
            <a href="{{ route('student.menu') }}" class="inline-block bg-[#2a2a2a] hover:bg-orange-500 text-white font-bold py-3 px-8 rounded-xl transition duration-300">
                Browse Menu
            </a>
        </div>
    @else
        <div class="max-w-3xl mx-auto bg-[#16161a] rounded-3xl border border-gray-800 p-8 shadow-2xl">
            
            @foreach($cart as $id => $item)
                @php $total += $item['price'] * $item['quantity']; @endphp
                
                <div class="flex justify-between items-center py-5 border-b border-gray-800 last:border-0">
                    <div>
                        <h3 class="text-white font-bold text-lg">{{ $item['name'] }}</h3>
                        <p class="text-gray-500 mt-1">Rs. {{ number_format($item['price'], 2) }} <span class="mx-2 text-gray-700">x</span> {{ $item['quantity'] }}</p>
                    </div>
                    <div class="text-white font-bold text-lg">
                        Rs. {{ number_format($item['price'] * $item['quantity'], 2) }}
                    </div>
                </div>
            @endforeach

            <div class="mt-8 pt-8 border-t border-gray-700 flex justify-between items-center">
                <span class="text-xl font-medium text-gray-400">Total to pay:</span>
                <span class="text-4xl font-black text-orange-500">Rs. {{ number_format($total, 2) }}</span>
            </div>

            <form action="{{ route('student.checkout') }}" method="POST" class="mt-10">
                @csrf
                <button type="submit" class="w-full bg-green-500 hover:bg-green-400 text-white font-black text-xl py-5 rounded-2xl transition duration-300 shadow-[0_0_25px_rgba(34,197,94,0.2)] hover:shadow-[0_0_35px_rgba(34,197,94,0.4)]">
                    Confirm & Get Queue Ticket
                </button>
            </form>
            
        </div>
    @endif

@endsection