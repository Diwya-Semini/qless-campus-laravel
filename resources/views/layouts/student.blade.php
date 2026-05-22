<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Q-Less Student')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0f0f12] text-gray-100 font-sans antialiased min-h-screen flex flex-col">

    <nav class="bg-[#16161a] border-b border-gray-800 sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            
            <a href="{{ route('student.canteens') }}" class="flex items-center gap-2 group">
                <span class="w-3 h-3 rounded-full bg-orange-500 group-hover:scale-125 transition duration-300"></span>
                <span class="text-xl font-black tracking-wider text-white uppercase">Q-Less<span class="text-orange-500 font-medium lowercase">.campus</span></span>
            </a>

            <div class="flex items-center gap-6">
                <a href="{{ route('student.canteens') }}" class="text-sm font-semibold {{ request()->routeIs('student.canteens') ? 'text-orange-500' : 'text-gray-400 hover:text-white' }} transition">
                    Browse Canteens
                </a>
                
                <a href="{{ route('student.orders') }}" class="text-sm font-semibold {{ request()->routeIs('student.orders') ? 'text-orange-500' : 'text-gray-400 hover:text-white' }} transition">
                    My Queues
                </a>
                
                <a href="{{ route('student.cart') }}" class="relative bg-[#222227] hover:bg-[#2c2c35] border border-gray-700 px-4 py-2 rounded-full flex items-center gap-2 text-sm transition shadow-md">
                    <span>🛒</span>
                    <span class="font-bold text-white hidden sm:inline">My Cart</span>
                    <span class="bg-[#ff5722] text-white text-xs font-black w-5 h-5 flex items-center justify-center rounded-full shadow">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>

                <div class="relative group cursor-pointer py-1">
                    <div class="w-9 h-9 rounded-full bg-orange-500/10 border border-orange-500/30 text-orange-400 flex items-center justify-center font-bold uppercase text-sm shadow-inner">
                        {{ substr(auth()->user()->name ?? 'S', 0, 1) }}
                    </div>
                    <div class="absolute right-0 mt-2 w-48 bg-[#16161a] rounded-xl shadow-2xl border border-gray-800 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <span class="block px-4 py-2 text-xs text-gray-500 border-b border-gray-800/60 mb-1 truncate">
                                {{ auth()->user()->email }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-400 hover:bg-red-950/20 rounded-lg transition font-medium">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto w-full px-6 py-8">
        @yield('content')
    </main>

    <footer class="bg-[#16161a] border-t border-gray-800/50 py-6 text-center text-xs text-gray-500 mt-auto tracking-wide">
        &copy; {{ date('Y') }} Q-Less SaaS Core. Multi-Tenant Campus Distribution System.
    </footer>

</body>
</html>