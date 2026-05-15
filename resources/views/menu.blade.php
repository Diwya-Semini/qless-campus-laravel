<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            Menu
        </h2>
    </x-slot>

    <div class="py-8 bg-[#0a0a0c] min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">Discover</h1>
                    <p class="text-neutral-500 text-sm">Manage your campus culinary catalog</p>
                </div>
                
                <div class="flex gap-4 w-full md:w-auto">
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" placeholder="Search dish..." 
                            class="w-full bg-[#1c1c1e] border-none text-white rounded-full py-3 pl-10 pr-4 focus:ring-1 focus:ring-orange-500 placeholder-neutral-500 text-sm">
                    </div>
                    
                    <a href="{{ route('menu.create') }}" class="bg-[#1c1c1e] hover:bg-orange-500 text-white p-3 rounded-full transition-colors duration-300 shadow-lg inline-flex items-center justify-center cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </a>
                </div>
            </div>

            <div class="flex space-x-3 overflow-x-auto pb-6 scrollbar-hide mb-2">
                <button class="bg-orange-500 text-white px-6 py-2 rounded-full font-medium text-sm shadow-lg shadow-orange-500/20 whitespace-nowrap">All Dishes</button>
                <button class="bg-[#1c1c1e] text-neutral-400 hover:text-white px-6 py-2 rounded-full font-medium text-sm transition-colors whitespace-nowrap">Mains</button>
                <button class="bg-[#1c1c1e] text-neutral-400 hover:text-white px-6 py-2 rounded-full font-medium text-sm transition-colors whitespace-nowrap">Beverages</button>
                <button class="bg-[#1c1c1e] text-neutral-400 hover:text-white px-6 py-2 rounded-full font-medium text-sm transition-colors whitespace-nowrap">Snacks</button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                @forelse($products as $product)
                    <div class="bg-[#151517] rounded-[24px] p-3 group hover:scale-[1.02] transition-transform duration-300">
                        
                        <div class="h-48 w-full rounded-[20px] mb-4 relative overflow-hidden bg-[#1c1c1e]">
                            <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" alt="{{ $product->item_name }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
                            
                            <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md px-3 py-1 rounded-full flex items-center border border-white/5">
                                <span class="text-[10px] font-bold uppercase tracking-wider {{ $product->is_available ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $product->is_available ? 'Available' : 'Sold Out' }}
                                </span>
                            </div>

                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                <a href="{{ route('menu.edit', $product->id) }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium backdrop-blur-md transition-colors">
    Edit Dish
</a>
                            </div>
                        </div>

                        <div class="px-2 pb-1">
                            <h3 class="text-white font-semibold text-lg tracking-wide truncate">{{ $product->item_name }}</h3>
                            
                            <div class="flex items-center gap-1 mt-1 mb-4">
                                <svg class="w-3 h-3 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span class="text-neutral-500 text-xs">{{ $product->category }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-white font-bold text-xl">
                                    <span class="text-orange-500 text-sm font-medium mr-1">Rs.</span>{{ number_format($product->price, 0) }}
                                </span>
                                
                                <a href="{{ route('menu.edit', $product->id) }}" class="bg-neutral-800 text-neutral-400 w-9 h-9 rounded-full flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all duration-300 shadow-lg border border-white/5 cursor-pointer inline-flex">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20">
                        <div class="w-20 h-20 bg-[#1c1c1e] rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-1">No Dishes Yet</h3>
                        <p class="text-neutral-500 text-sm text-center max-w-xs">Click the + button at the top to add your first menu item.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>