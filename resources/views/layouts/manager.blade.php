<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manager - Qless Campus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles </head>
<body class="font-sans antialiased bg-[#0f0f13] text-gray-100 flex h-screen overflow-hidden selection:bg-orange-500 selection:text-white">

    <x-side-nav>
        <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-4">Canteen Operations</p>

        <a href="{{ route('manager.orders') }}"
           class="{{ request()->routeIs('manager.orders') ? 'bg-orange-500/10 text-orange-400 border border-orange-500/20 shadow-inner' : 'text-gray-400 hover:bg-white/5 hover:text-white border border-transparent' }} flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 group font-semibold text-sm">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            Live Orders
        </a>

        <a href="#"
           class="text-gray-400 hover:bg-white/5 hover:text-white border border-transparent flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 group font-semibold text-sm">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
            Menu Management
        </a>
    </x-side-nav>

    <main class="flex-1 h-screen overflow-y-auto relative custom-scrollbar">
        <div class="p-4 md:p-8">
            @yield('content')
            {{ $slot ?? '' }} 
        </div>
    </main>

    @livewireScripts <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #2d2d35; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3d3d45; }
    </style>
</body>
</html>