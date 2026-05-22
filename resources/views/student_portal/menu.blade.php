@extends('layouts.student')

@section('content')
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 border-b border-gray-800 pb-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-gray-600"></div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Main Canteen</h1>
        </div>
        
        <form action="{{ route('student.menu') }}" method="GET" class="relative w-full md:w-72">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search in site..." 
                   class="w-full bg-[#16161a] border border-gray-800 rounded-xl px-4 py-2 text-sm text-gray-200 placeholder-gray-500 focus:outline-none focus:border-orange-500 transition">
            
            <button type="submit" class="absolute right-3 top-2.5 text-gray-500 hover:text-white transition text-sm">
                🔍
            </button>
        </form>
    </div>

    <div class="flex items-center gap-3 overflow-x-auto pb-4 mb-8 no-scrollbar">
        
        <a href="{{ route('student.menu') }}" 
           class="px-6 py-2.5 rounded-full text-sm font-bold transition {{ !request('category') ? 'bg-orange-500 text-white shadow-[0_4px_12px_rgba(234,88,12,0.3)]' : 'bg-[#16161a] text-gray-400 border border-gray-800 hover:text-white' }}">
            All Items
        </a>

        <a href="{{ route('student.menu', ['category' => 'Mains', 'search' => request('search')]) }}" 
           class="px-6 py-2.5 rounded-full text-sm font-bold transition {{ request('category') === 'Mains' ? 'bg-orange-500 text-white shadow-[0_4px_12px_rgba(234,88,12,0.3)]' : 'bg-[#16161a] text-gray-400 border border-gray-800 hover:text-white' }}">
            Mains
        </a>

        <a href="{{ route('student.menu', ['category' => 'Beverages', 'search' => request('search')]) }}" 
           class="px-6 py-2.5 rounded-full text-sm font-bold transition {{ request('category') === 'Beverages' ? 'bg-orange-500 text-white shadow-[0_4px_12px_rgba(234,88,12,0.3)]' : 'bg-[#16161a] text-gray-400 border border-gray-800 hover:text-white' }}">
            Beverages
        </a>

        <a href="{{ route('student.menu', ['category' => 'Snacks', 'search' => request('search')]) }}" 
           class="px-6 py-2.5 rounded-full text-sm font-bold transition {{ request('category') === 'Snacks' ? 'bg-orange-500 text-white shadow-[0_4px_12px_rgba(234,88,12,0.3)]' : 'bg-[#16161a] text-gray-400 border border-gray-800 hover:text-white' }}">
            Snacks
        </a>
    </div>

    @if(request('search') || request('category'))
        <div class="mb-6 flex items-center gap-2 text-sm text-gray-400">
            <span>Showing filtered results</span>
            <a href="{{ route('student.menu') }}" class="text-orange-500 hover:underline font-semibold ml-1">
                Clear Filters ✕
            </a>
        </div>
    @endif

    @if($products->isEmpty())
        <div class="text-center text-gray-500 py-16 bg-[#16161a] rounded-3xl border border-gray-800/60 w-full col-span-full">
            No culinary options found matching your filter criteria.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-24">
            @foreach($products as $product)
                <x-food-card :product="$product" />
            @endforeach
        </div>
    @endif

    @php
        $cart = session('cart', []);
        $itemCount = 0;
        $cartTotal = 0;
        foreach($cart as $item) {
            $itemCount += $item['quantity'];
            $cartTotal += $item['price'] * $item['quantity'];
        }
    @endphp

    @if($itemCount > 0)
        <div class="fixed bottom-0 left-0 right-0 bg-orange-600 hover:bg-orange-500 text-white font-bold shadow-[0_-8px_24px_rgba(0,0,0,0.5)] transition duration-300 z-50">
            <a href="{{ route('student.cart') }}" class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center text-lg tracking-wide">
                <div class="flex items-center gap-2">
                    <span>{{ $itemCount }} {{ $itemCount == 1 ? 'Item' : 'Items' }}</span>
                    <span class="text-orange-200">•</span>
                    <span class="underline underline-offset-4">View Cart</span>
                </div>
                <div>
                    Rs. {{ number_format($cartTotal, 2) }}
                </div>
            </a>
        </div>
    @endif

@endsection