<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Dish - Q-Less</title>
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
            <a href="{{ route('menu.index') }}" class="flex items-center px-4 py-3 bg-[#2a2a2a] rounded-lg text-white font-medium border-l-4 border-orange-500">
                <div class="w-5 h-5 rounded bg-gray-600 mr-3"></div>
                Menu Management
            </a>
            <a href="{{ route('ledger.index') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-[#222] rounded-lg transition">
                <div class="w-5 h-5 rounded bg-gray-800 mr-3"></div>
                Ledger
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <header class="py-6 px-10 border-b border-gray-800 bg-[#121212] flex items-center justify-between w-full relative z-50">
            
            <div class="flex items-center gap-5">
                <a href="{{ route('menu.index') }}" class="w-10 h-10 rounded-full bg-[#1a1a1a] border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 hover:border-gray-500 transition shadow-sm">
                    <svg class="w-5 h-5 pr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <span class="text-2xl font-bold text-white tracking-wide">Add New Dish</span>
            </div>

            <div class="relative group cursor-pointer">
                
                <div class="bg-[#1a1a1a] border border-gray-700 group-hover:bg-gray-700 text-gray-300 group-hover:text-white text-sm font-semibold py-2.5 px-6 rounded-full transition shadow-sm flex items-center gap-2">
                    {{ auth()->user()->name ?? 'System Admin' }} 
                    <svg class="w-4 h-4 transform group-hover:rotate-180 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div class="absolute right-0 mt-2 w-48 bg-[#1a1a1a] rounded-xl shadow-2xl border border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right group-hover:translate-y-0 translate-y-2">
                    <div class="p-2">
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

        <div class="p-8 max-w-3xl mx-auto w-full">
            <div class="bg-[#1a1a1a] border border-gray-800 rounded-2xl p-8 shadow-xl">
                
                <h2 class="text-2xl font-bold text-white mb-6">Create a <span class="text-orange-500">New Menu Item</span></h2>

                @if ($errors->any())
                    <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded mb-6">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('menu.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Item Name <span class="text-red-500">*</span></label>
                            <input type="text" name="item_name" value="{{ old('item_name') }}" required placeholder="e.g. Chicken Kottu" class="w-full bg-[#121212] border border-gray-700 text-white rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Price (Rs.) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="price" value="{{ old('price') }}" required placeholder="0.00" class="w-full bg-[#121212] border border-gray-700 text-white rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Category</label>
                            <select name="category" class="w-full bg-[#121212] border border-gray-700 text-white rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5">
                                <option value="Mains" {{ old('category') == 'Mains' ? 'selected' : '' }}>Mains</option>
                                <option value="Beverages" {{ old('category') == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                                <option value="Snacks" {{ old('category') == 'Snacks' ? 'selected' : '' }}>Snacks</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Image URL (https://...)</label>
                            <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="Paste Unsplash image link..." class="w-full bg-[#121212] border border-gray-700 text-white rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
                        <textarea name="description" rows="3" placeholder="Briefly describe the ingredients or dish..." class="w-full bg-[#121212] border border-gray-700 text-white rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex items-center bg-[#121212] border border-gray-700 p-4 rounded-lg">
                        <input type="checkbox" name="isAvailable" id="isAvailable" value="1" checked class="w-5 h-5 text-orange-500 bg-[#1a1a1a] border-gray-600 rounded focus:ring-orange-500 focus:ring-2">
                        <label for="isAvailable" class="ml-3 text-sm font-medium text-white">Make this item instantly available for ordering</label>
                    </div>

                    <div class="pt-4 border-t border-gray-800 flex justify-end gap-4">
                        <a href="{{ route('menu.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-600 text-gray-300 hover:bg-gray-800 transition">Cancel</a>
                        <button type="submit" class="bg-[#ff5722] hover:bg-orange-600 text-white font-bold px-8 py-2.5 rounded-lg transition shadow-lg">Add Dish to Menu</button>
                    </div>
                </form>

            </div>
        </div>
    </main>
</body>
</html>