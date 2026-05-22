@extends('layouts.manager')

@section('title', 'Canteen Settings - Q-Less')

@section('header_left')
    <span class="text-2xl font-bold text-white tracking-wide">Settings</span>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        
        @if(session('success'))
            <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#1a1a1a] border border-gray-800 rounded-2xl p-8 shadow-xl">
            <h2 class="text-xl font-bold text-white mb-2">Store Operation Control</h2>
            <p class="text-gray-400 text-sm mb-6">Instantly toggle your canteen visibility on the student mobile applications.</p>

            <div class="flex items-center justify-between p-6 bg-[#121212] border border-gray-800 rounded-xl">
                <div>
                    <div class="text-lg font-bold text-white flex items-center gap-2">
                        System Status: 
                        @if($isOpen)
                            <span class="text-green-400 text-sm bg-green-950 px-2 py-0.5 rounded border border-green-800 uppercase">Live & Accepting Orders</span>
                        @else
                            <span class="text-red-400 text-sm bg-red-950 px-2 py-0.5 rounded border border-red-800 uppercase">Suspended / Closed</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Closing the store prevents students from initializing checkout line entries.</p>
                </div>

                <form action="{{ route('manager.settings.toggle') }}" method="POST">
                    @csrf
                    <button type="submit" class="font-bold py-3 px-6 rounded-xl transition shadow-md {{ $isOpen ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                        {{ $isOpen ? 'Close Canteen 🛑' : 'Open Canteen 🚀' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection