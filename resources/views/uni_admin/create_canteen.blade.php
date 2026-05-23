<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-white">Deploy New Canteen</h1>
                <p class="text-sm text-gray-400 mt-1">Manually provision a new university campus location to the network.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-400 hover:text-white transition">
                ← Cancel & Return
            </a>
        </div>

        <div class="bg-white/[0.02] rounded-2xl border border-white/5 shadow-2xl p-8 backdrop-blur-xl">
            <form action="{{ route('admin.canteen.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Canteen/Outlet Name</label>
                    <input type="text" name="name" required placeholder="e.g. SLIIT Main Cafeteria" 
                           class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 focus:outline-none focus:border-orange-500 transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">University Campus</label>
                    <input type="text" name="location" required placeholder="e.g. SLIIT Malabe Campus" 
                           class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 focus:outline-none focus:border-orange-500 transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Operating Hours</label>
                    <input type="text" name="operating_hours" required placeholder="e.g. 7:00 AM - 6:00 PM" 
                           class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 focus:outline-none focus:border-orange-500 transition-colors">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-400 hover:to-orange-500 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-orange-500/20 transition-all duration-200">
                        Provision Canteen Tenant
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>