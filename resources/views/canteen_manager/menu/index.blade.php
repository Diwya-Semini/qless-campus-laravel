<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management - Q-Less</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#121212] text-gray-200 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-[#1a1a1a] border-r border-gray-800 flex flex-col">
        <div class="h-16 flex items-center px-6 border-b border-gray-800">
            <div class="w-4 h-4 rounded-full bg-gray-500 mr-3"></div>
            <h1 class="text-lg font-bold tracking-wide text-white">Q-Less Campus</h1>
        </div>
        <nav class="flex-1 py-4 flex flex-col gap-2 px-3">
            <a href="{{ route('manager.dashboard') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-[#222] rounded-lg transition">
                <div class="w-5 h-5 rounded bg-gray-800 mr-3"></div>
                Live Orders
            </a>
            <a href="#" class="flex items-center px-4 py-3 bg-[#2a2a2a] rounded-lg text-white font-medium border-l-4 border-orange-500">
                <div class="w-5 h-5 rounded bg-gray-600 mr-3"></div>
                Menu Management
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-[#222] rounded-lg transition">
                <div class="w-5 h-5 rounded bg-gray-800 mr-3"></div>
                Order History
            </a>
            <a href="{{ route('manager.settings') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('manager.settings') ? 'bg-[#2a2a2a] text-white border-l-4 border-orange-500 font-medium' : 'text-gray-400 hover:text-white hover:bg-[#222]' }} rounded-lg transition">
                <div class="w-5 h-5 rounded bg-gray-800 mr-3"></div>
                Settings
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <header class="py-6 px-10 border-b border-gray-800 bg-[#121212] flex items-center justify-between w-full relative z-50">
            
            <div class="flex items-center gap-5">
                <span class="text-2xl font-bold text-white tracking-wide">Menu Management</span>
            </div>

            <div class="relative group cursor-pointer">
                
                <div class="bg-[#1a1a1a] border border-gray-700 group-hover:bg-gray-700 text-gray-300 group-hover:text-white text-sm font-semibold py-2.5 px-6 rounded-full transition shadow-sm flex items-center gap-2">
                    {{ auth()->user()->name ?? 'System Admin' }} 
                    <svg class="w-4 h-4 transform group-hover:rotate-180 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div class="absolute right-0 mt-2 w-48 bg-[#1a1a1a] rounded-xl shadow-2xl border border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right group-hover:translate-y-0 translate-y-2 z-50">
                    <div class="p-2 bg-[#1a1a1a] rounded-xl">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#2a2a2a] hover:text-white rounded-lg transition">
                            Profile Settings
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 mt-1">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-400 hover:bg-red-900/50 hover:text-red-300 rounded-lg transition">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            
            @if(session('success'))
                <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-4xl font-bold text-white mb-2">Discover</h2>
                    <p class="text-gray-400">Manage your campus culinary catalog</p>
                </div>
                <div class="flex gap-4 items-center">
                    <form action="{{ route('menu.index') }}" method="GET" class="relative">
                        <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search dish..." class="bg-[#1a1a1a] border border-gray-700 text-white text-sm rounded-full focus:ring-orange-500 focus:border-orange-500 block w-64 pl-10 p-2.5">
                        <button type="submit" class="hidden"></button> 
                    </form>
                    <a href="{{ route('menu.create') }}" class="w-10 h-10 bg-[#1a1a1a] border border-gray-700 hover:bg-gray-700 rounded-full flex items-center justify-center text-gray-300 transition shadow-lg">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    </a>
                </div>
            </div>

            <div class="flex gap-3 mb-8">
                <button class="bg-[#ff5722] text-white px-5 py-2 rounded-full text-sm font-bold">All Dishes</button>
                <button class="bg-[#1a1a1a] text-gray-400 hover:bg-[#222] border border-transparent hover:border-gray-700 px-5 py-2 rounded-full text-sm font-bold transition">Mains</button>
                <button class="bg-[#1a1a1a] text-gray-400 hover:bg-[#222] border border-transparent hover:border-gray-700 px-5 py-2 rounded-full text-sm font-bold transition">Beverages</button>
                <button class="bg-[#1a1a1a] text-gray-400 hover:bg-[#222] border border-transparent hover:border-gray-700 px-5 py-2 rounded-full text-sm font-bold transition">Snacks</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                @forelse($products as $product)
                <div class="bg-[#1a1a1a] border border-gray-800 rounded-3xl p-4 flex flex-col hover:border-gray-700 transition duration-300 group shadow-lg">
                    
                    <div class="relative h-48 w-full mb-4 overflow-hidden rounded-2xl">
                        <img src="{{ !empty($product->image_url) ? $product->image_url : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&h=400&fit=crop' }}" alt="{{ $product->item_name }}" class="w-full h-full object-cover rounded-2xl transform group-hover:scale-105 transition duration-500">
                        
                        <div class="absolute top-3 left-3">
                            @if($product->isAvailable === true)
                                <span class="bg-green-900/90 border border-green-700 text-green-300 text-[10px] font-bold px-3 py-1 rounded-md tracking-wider uppercase backdrop-blur-sm shadow-sm">
                                    Available
                                </span>
                            @else
                                <span class="bg-red-900/90 border border-red-700 text-red-300 text-[10px] font-bold px-3 py-1 rounded-md tracking-wider uppercase backdrop-blur-sm shadow-sm">
                                    Sold Out
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="px-2 flex-1">
                        <h3 class="text-xl font-bold text-white mb-1 truncate">{{ $product->item_name }}</h3>
                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <svg class="w-4 h-4 text-[#ff5722] mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            {{ $product->category ?? 'General' }}
                        </div>
                    </div>

                    <div class="px-2 flex justify-between items-center mt-auto pb-2 border-t border-gray-800/50 pt-4">
                        <div class="text-[#ff5722] font-black text-xl">
                            <span class="text-sm font-medium mr-1 text-gray-400">Rs.</span>{{ number_format($product->price, 2) }}
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('menu.edit', $product->id) }}" class="w-8 h-8 rounded-full bg-[#2a2a2a] hover:bg-gray-600 flex items-center justify-center transition">
                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('menu.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $product->item_name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-full bg-[#2a2a2a] hover:bg-red-900/50 hover:text-red-400 flex items-center justify-center transition">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-span-full py-16 text-center text-gray-500 bg-[#1a1a1a] rounded-2xl border border-gray-800 border-dashed">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        <p class="text-xl font-semibold text-gray-400">Your menu is currently empty.</p>
                        <p class="mt-2 text-sm text-gray-500">Click the <span class="text-orange-500 font-bold">+</span> button above to add your first dish.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </main>
</body>
</html>