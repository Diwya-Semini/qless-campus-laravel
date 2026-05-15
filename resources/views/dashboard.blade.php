<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            <span class="text-orange-500">Q-Less</span> Live Orders
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gray-800 overflow-hidden shadow-2xl sm:rounded-xl p-6 border border-gray-700">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">Live Order Queue</h3>
                    <span class="px-3 py-1 bg-green-500/10 text-green-400 rounded-full text-sm font-bold flex items-center gap-2 border border-green-500/20">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        Live Status
                    </span>
                </div>

                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900 rounded-t-lg">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap font-black text-orange-500 text-lg">
                                {{ $order->queue_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-200 font-medium">
                                {{ $order->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-400">
                                {{ $order->canteen->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap flex items-center gap-4">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase tracking-wide
                                    {{ $order->status === 'ready' ? 'bg-green-500/10 text-green-500 border border-green-500/20' : 'bg-orange-500/10 text-orange-500 border border-orange-500/20' }}">
                                    {{ $order->status }}
                                </span>
                                @if($order->status === 'pending')
                                    <form action="{{ route('orders.ready', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold rounded shadow transition-colors duration-200">
                                            Mark as Ready
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>