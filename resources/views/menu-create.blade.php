<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            Add New Dish
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0a0a0c] min-h-screen font-sans">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('menu.index') }}" class="text-neutral-500 hover:text-orange-500 flex items-center gap-2 transition-colors w-fit font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Menu
                </a>
            </div>

            <div class="bg-[#151517] rounded-[24px] p-8 shadow-2xl border border-white/5 relative overflow-hidden">
                
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-orange-500/10 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <h1 class="text-2xl font-bold text-white mb-2">Dish Details</h1>
                    <p class="text-neutral-500 text-sm mb-8">Enter the information below to add a new item to your catalog.</p>

                    <form action="{{ route('menu.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="item_name" class="block text-sm font-medium text-neutral-400 mb-2">Dish Name</label>
                            <input type="text" name="item_name" id="item_name" required
                                class="w-full !bg-[#1c1c1e] border border-gray-700 !text-white rounded-xl py-3 px-4 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 placeholder-neutral-600 shadow-inner"
                                placeholder="e.g. Spicy Chicken Tacos">
                            @error('item_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="image_url" class="block text-sm font-medium text-neutral-400 mb-2">Image URL (Optional)</label>
                            <input type="text" name="image_url" id="image_url"
                                class="w-full !bg-[#1c1c1e] border border-gray-700 !text-white rounded-xl py-3 px-4 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 placeholder-neutral-600 shadow-inner"
                                placeholder="e.g. https://images.unsplash.com/photo-...">
                            <p class="text-neutral-500 text-xs mt-2">Paste a direct link to a high-quality photo of the dish.</p>
                            @error('image_url') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="category" class="block text-sm font-medium text-neutral-400 mb-2">Category</label>
                                <select name="category" id="category" required
                                    class="w-full !bg-[#1c1c1e] border border-gray-700 !text-white rounded-xl py-3 px-4 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 shadow-inner">
                                    <option value="" disabled selected>Select category...</option>
                                    <option value="Mains">Mains</option>
                                    <option value="Beverages">Beverages</option>
                                    <option value="Snacks">Snacks</option>
                                </select>
                                @error('category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-neutral-400 mb-2">Price (Rs.)</label>
                                <div class="flex items-center !bg-[#1c1c1e] border border-gray-700 rounded-xl overflow-hidden focus-within:ring-1 focus-within:ring-orange-500 focus-within:border-orange-500 shadow-inner">
                                    <span class="pl-4 pr-2 text-neutral-500 font-medium">Rs.</span>
                                    <input type="number" step="0.01" name="price" id="price" required min="0"
                                        class="w-full bg-transparent border-none !text-white py-3 px-2 focus:ring-0 placeholder-neutral-600"
                                        placeholder="0.00">
                                </div>
                                @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-10 flex items-center justify-between p-5 !bg-[#1c1c1e] rounded-xl border border-gray-700 shadow-inner">
                            <div>
                                <h3 class="text-white font-medium mb-1">Available in Stock</h3>
                                <p class="text-neutral-500 text-sm">Allow students to see and order this item immediately.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_available" value="1" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                            </label>
                        </div>

                        <div class="flex justify-end items-center gap-4 mt-8 border-t border-white/5 pt-6">
                            <a href="{{ route('menu.index') }}" class="px-6 py-3 text-neutral-400 hover:text-white font-medium transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-orange-500/20 transition-all duration-300 transform hover:-translate-y-1">
                                Save Dish
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>