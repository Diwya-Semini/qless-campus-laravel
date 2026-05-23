<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Qless Campus') }} - Admin Command</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0f0f13] text-gray-100 flex h-screen overflow-hidden selection:bg-orange-500 selection:text-white">

    <x-side-nav>
        <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-4">Command Center</p>

        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.canteen.create') ? 'bg-orange-500/10 text-orange-400 border border-orange-500/20 shadow-inner' : 'text-gray-400 hover:bg-white/5 hover:text-white border border-transparent' }} flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 group font-semibold text-sm">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-orange-400' : 'text-gray-500 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Network Canteens
        </a>

        <a href="{{ route('admin.users') }}"
           class="{{ request()->routeIs('admin.users') ? 'bg-orange-500/10 text-orange-400 border border-orange-500/20 shadow-inner' : 'text-gray-400 hover:bg-white/5 hover:text-white border border-transparent' }} flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 group font-semibold text-sm">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users') ? 'text-orange-400' : 'text-gray-500 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Platform Managers
        </a>
    </x-side-nav>

    <main class="flex-1 h-screen overflow-y-auto relative custom-scrollbar">
        <div class="md:hidden h-16 border-b border-white/5 flex items-center px-4 justify-between bg-[#16161a]">
            <span class="text-orange-500 font-black text-xl">Q-LESS <span class="text-white">Campus</span></span>
        </div>
        
        <div class="p-4 md:p-8">
            @yield('content')
        </div>
    </main>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #2d2d35; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3d3d45; }
    </style>
</body>
</html>