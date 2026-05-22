<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            Edit Dish
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
                    <h1 class="text-2xl font-bold text-white mb-2">Edit Details</h1>
                    <p class="text-neutral-500 text-sm mb-8">Update the information for your catalog item.</p>

                    <form action="{{ route('menu.update', $product->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') 

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Item Name</label>
                            <input type="text" name="item_name" value="{{ old('item_name', $product->item_name) }}" class="w-full bg-[#121212] border border-gray-700 text-white rounded-lg p-2.5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Price (Rs.)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full bg-[#121212] border border-gray-700 text-white rounded-lg p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Category</label>
                            <select name="category" class="w-full bg-[#121212] border border-gray-700 text-white rounded-lg p-2.5">
                                <option value="Mains" {{ $product->category == 'Mains' ? 'selected' : '' }}>Mains</option>
                                <option value="Beverages" {{ $product->category == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                                <option value="Snacks" {{ $product->category == 'Snacks' ? 'selected' : '' }}>Snacks</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Image URL (https://...)</label>
                            <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}" placeholder="Paste image web link..." class="w-full bg-[#121212] border border-gray-700 text-white rounded-lg p-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full bg-[#121212] border border-gray-700 text-white rounded-lg p-2.5">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="flex items-center bg-[#121212] border border-gray-700 p-4 rounded-lg">
                        <input type="checkbox" name="isAvailable" id="isAvailable" value="1" {{ $product->isAvailable ? 'checked' : '' }} class="w-5 h-5 text-orange-500 bg-[#1a1a1a] border-gray-600 rounded">
                        <label for="isAvailable" class="ml-3 text-sm font-medium text-white">Item is currently available for students to order</label>
                    </div>

                    <div class="pt-4 border-t border-gray-800 flex justify-end gap-4">
                        <a href="{{ route('menu.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-600 text-gray-300 hover:bg-gray-800 transition">Cancel</a>
                        <button type="submit" class="bg-[#ff5722] hover:bg-orange-600 text-white font-bold px-8 py-2.5 rounded-lg transition">Save Changes</button>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>