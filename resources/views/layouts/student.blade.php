<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q-Less Student</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0f0f12] text-gray-100 font-sans antialiased min-h-screen flex flex-col">

    <nav class="bg-[#16161a] border-b border-gray-800 p-4 sticky top-0 z-50 shadow-lg shadow-black/50">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            
            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2">                <span class="w-3 h-3 rounded-full bg-orange-500 shadow-[0_0_10px_rgba(255,87,34,0.8)]"></span>
                <div class="text-xl font-black text-white tracking-widest uppercase">Q-LESS<span class="text-orange-500 font-medium lowercase">.campus</span></div>
            </a>

            <div class="flex items-center gap-6 font-semibold text-sm">
            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2">                
                <a href="{{ route('student.cart') }}" class="text-gray-300 hover:text-orange-500 transition flex items-center gap-1">
                    Tray 
                    @if(count(session('cart', [])) > 0)
                        <span class="bg-orange-500 text-white text-xs px-2 py-0.5 rounded-full">{{ count(session('cart', [])) }}</span>
                    @endif
                </a>
                
                <a href="{{ route('student.orders') }}" class="text-gray-300 hover:text-green-400 transition">My Queues</a>
                
                <span class="text-gray-700">|</span>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-500 transition">Logout</button>
                </form>
            </div>

        </div>
    </nav>

    <main class="flex-grow p-6 max-w-6xl mx-auto w-full mt-4">
        @yield('content')
    </main>

</body>
</html>