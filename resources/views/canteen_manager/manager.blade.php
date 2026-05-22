<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Dashboard - Q-Less</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#121212] text-gray-200 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-[#1a1a1a] border-r border-gray-800 flex flex-col">
        <div class="h-16 flex items-center px-6 border-b border-gray-800">
            <div class="w-4 h-4 rounded-full bg-gray-500 mr-3"></div>
            <h1 class="text-lg font-bold tracking-wide text-white">Q-Less Campus</h1>
        </div>
        <nav class="flex-1 py-4 flex flex-col gap-2 px-3">
            <a href="#" class="flex items-center px-4 py-3 bg-[#2a2a2a] rounded-lg text-white font-medium border-l-4 border-gray-400">
                <div class="w-5 h-5 rounded bg-gray-600 mr-3"></div>
                Live Orders
            </a>
            <a href="{{ route('menu.index') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-[#222] rounded-lg transition">
                <div class="w-5 h-5 rounded bg-gray-800 mr-3"></div>
                Menu Management
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-[#222] rounded-lg transition">
                <div class="w-5 h-5 rounded bg-gray-800 mr-3"></div>
                Order History
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-[#222] rounded-lg transition">
                <div class="w-5 h-5 rounded bg-gray-800 mr-3"></div>
                Settings
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <header class="h-16 flex items-center justify-between px-8 border-b border-gray-800 bg-[#121212]">
            <div class="flex items-center text-gray-300">
                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <span class="text-xl font-semibold text-white">Canteen Name</span>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-[#ff5722] hover:bg-[#e64a19] text-white text-sm font-bold py-2 px-6 rounded-full transition">
                    Logout
                </button>
            </form>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            
            @if(session('success'))
                <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 flex flex-col gap-6">
                    
                    <div class="grid grid-cols-2 gap-6">
                        
                        <div class="bg-[#1a1a1a] border border-gray-800 rounded-xl p-6">
                            <h3 class="text-gray-400 text-sm font-semibold mb-1">Total Orders Today</h3>
                            <div class="text-3xl font-bold text-white mb-6">17</div>
                            <div class="h-32 w-full relative">
                                <div class="absolute inset-0 flex flex-col justify-between">
                                    <div class="border-t border-gray-800 w-full h-0"></div>
                                    <div class="border-t border-gray-800 w-full h-0"></div>
                                    <div class="border-t border-gray-800 w-full h-0"></div>
                                    <div class="border-t border-gray-800 w-full h-0"></div>
                                </div>
                                <svg class="w-full h-full" viewBox="0 0 100 50" preserveAspectRatio="none">
                                    <polyline fill="none" stroke="#6b7280" stroke-width="1.5" points="0,45 20,40 40,20 60,45 80,10 100,45" />
                                </svg>
                                <div class="absolute -bottom-6 left-0 right-0 flex justify-between text-[10px] text-gray-500 font-bold">
                                    <span>8 AM</span><span>10 AM</span><span>12 PM</span><span>2 PM</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-[#1a1a1a] border border-gray-800 rounded-xl p-6 relative overflow-hidden">
                            <h3 class="text-gray-400 text-sm font-semibold mb-1">Avg Prep Time</h3>
                            <div class="text-4xl font-bold text-white mb-4">12m</div>
                            <div class="absolute right-6 top-1/2 transform -translate-y-1/2 opacity-80">
                                <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h6m-3-3v6"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#1a1a1a] border border-gray-800 rounded-xl p-6 flex-1">
                        <div class="flex items-center mb-6 bg-[#121212] border border-gray-800 rounded-lg p-2 w-64">
                            <span class="text-sm text-gray-500 mr-2">Enter the Order ID</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>

                        <h3 class="text-white font-bold mb-4">Live Order Queue</h3>
                        
                        <div class="w-full">
                            <div class="grid grid-cols-12 text-sm font-bold text-gray-400 mb-4 px-2">
                                <div class="col-span-2">Order ID</div>
                                <div class="col-span-5 text-center">Items</div>
                                <div class="col-span-2 text-center">Pickup</div>
                                <div class="col-span-2 text-center">Time In</div>
                                <div class="col-span-1 text-center">Status</div>
                            </div>
                            
                            <div class="space-y-2">
                                @forelse($pendingOrders as $order)
                                    <div class="grid grid-cols-12 items-center bg-[#222] p-3 rounded-lg text-sm">
                                        <div class="col-span-2 text-gray-300 font-mono">{{ $order->queue_number }}</div>
                                        <div class="col-span-5 text-gray-300 text-center truncate px-2">
                                            @foreach($order->items as $index => $item)
                                                {{ $item->product->itemName ?? 'Item' }}{{ !$loop->last ? ',' : '' }}
                                            @endforeach
                                        </div>
                                        <div class="col-span-2 text-gray-400 text-center">{{ \Carbon\Carbon::parse($order->created_at)->addMinutes(15)->format('g:i A') }}</div>
                                        <div class="col-span-2 text-gray-400 text-center">{{ $order->created_at->format('g:i A') }}</div>
                                        <div class="col-span-1 flex justify-center">
                                            <form action="{{ route('orders.ready', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-[#ff5722] text-white text-xs font-bold px-3 py-1 rounded-full hover:bg-orange-600 transition">
                                                    Ready
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500">No pending orders.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    
                    <div class="bg-[#1a1a1a] border border-gray-800 rounded-xl p-6 h-[400px]">
                        <h3 class="text-gray-400 text-sm font-semibold mb-4">Popular Items</h3>
                        <div class="space-y-4">
                            <div class="flex items-center border border-gray-700 bg-[#222] p-2 rounded-lg">
                                <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?w=100&h=100&fit=crop" class="w-16 h-16 rounded object-cover mr-4" alt="Burger">
                                <div>
                                    <div class="text-gray-200 font-bold text-sm">Chicken Sandwich</div>
                                    <div class="text-gray-400 text-xs mt-1">Rs. 650.00</div>
                                </div>
                            </div>
                            <div class="flex items-center border border-gray-700 bg-[#222] p-2 rounded-lg">
                                <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=100&h=100&fit=crop" class="w-16 h-16 rounded object-cover mr-4" alt="Coffee">
                                <div>
                                    <div class="text-gray-200 font-bold text-sm">Hot Nescafe</div>
                                    <div class="text-gray-400 text-xs mt-1">Rs. 120.00</div>
                                </div>
                            </div>
                            <div class="flex items-center border border-gray-700 bg-[#222] p-2 rounded-lg">
                                <img src="https://images.unsplash.com/photo-1626804475297-41609ea14eb1?w=100&h=100&fit=crop" class="w-16 h-16 rounded object-cover mr-4" alt="Kottu">
                                <div>
                                    <div class="text-gray-200 font-bold text-sm">Kottu</div>
                                    <div class="text-gray-400 text-xs mt-1">Rs. 700.00</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#1a1a1a] border border-gray-800 rounded-xl p-6 flex-1">
                        <h3 class="text-gray-400 text-sm font-semibold mb-4">Low Stock Alert</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                                <span class="text-gray-300 text-sm font-medium">Chicken Sandwich</span>
                                <span class="bg-red-900/50 border border-red-800 text-red-400 text-xs px-3 py-1 rounded-full">5 Item Left</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                                <span class="text-gray-300 text-sm font-medium">Yoghurt</span>
                                <span class="bg-red-900/50 border border-red-800 text-red-400 text-xs px-3 py-1 rounded-full">1 Item Left</span>
                            </div>
                            <div class="flex items-center justify-between pb-1">
                                <span class="text-gray-300 text-sm font-medium">Pastry</span>
                                <span class="bg-red-900/50 border border-red-800 text-red-400 text-xs px-3 py-1 rounded-full">0 Item Left</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</body>
</html>