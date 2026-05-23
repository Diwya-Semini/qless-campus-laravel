<aside class="w-72 bg-[#16161a] border-r border-white/5 flex flex-col justify-between hidden md:flex z-50 shadow-2xl h-screen">
    
    <div>
        <div class="h-20 flex items-center px-8 border-b border-white/5 bg-[#1a1a1f]">
            <div class="w-2.5 h-2.5 rounded-full bg-orange-500 mr-3 shadow-[0_0_10px_rgba(249,115,22,0.8)] animate-pulse"></div>
            <span class="text-orange-500 font-black tracking-tighter text-2xl drop-shadow-md">Q-LESS</span>
            <span class="text-white font-bold tracking-tight text-2xl ml-1.5">Campus</span>
        </div>

        <nav class="mt-8 px-4 space-y-2">
            {{ $slot }}
        </nav>
    </div>

    <div class="p-4 border-t border-white/5 bg-[#131317]">
        <div class="bg-black/40 border border-white/5 rounded-xl p-3 flex items-center justify-between hover:border-white/10 transition">
            <div class="flex items-center">
                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center text-white font-bold text-sm shadow-inner border border-white/10">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-gray-200 leading-none truncate w-24">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-[10px] text-orange-500 mt-1 uppercase tracking-widest font-bold">{{ auth()->user()->role ?? 'Account' }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-orange-500 transition p-2 bg-white/5 rounded-lg hover:bg-orange-500/10" title="Secure Logout">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </div>
</aside>