@extends('layouts.manager')

@section('title', 'Order History - Q-Less')

@section('header_left')
    <span class="text-2xl font-bold text-white tracking-wide">Order History</span>
@endsection

@section('content')
    <div class="bg-[#1a1a1a] border border-gray-800 rounded-2xl p-6 shadow-xl">
        <h2 class="text-xl font-bold text-white mb-6">Past & Completed Orders</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-300">
                <thead class="text-xs uppercase bg-[#121212] text-gray-400 border-b border-gray-800">
                    <tr>
                        <th class="py-4 px-4">Queue ID</th>
                        <th class="py-4 px-4">Student</th>
                        <th class="py-4 px-4">Items Summary</th>
                        <th class="py-4 px-4 text-center">Amount</th>
                        <th class="py-4 px-4 text-center">Completed At</th>
                        <th class="py-4 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    @forelse($completedOrders as $order)
                        <tr class="hover:bg-[#222] transition">
                            <td class="py-4 px-4 font-mono text-orange-500 font-bold">#{{ $order->queue_number }}</td>
                            <td class="py-4 px-4 text-white font-medium">{{ $order->user->name ?? 'Student' }}</td>
                            <td class="py-4 px-4 max-w-xs truncate">
                                @foreach($order->items as $item)
                                    {{ $item->product->item_name ?? 'Item' }} (x{{ $item->quantity }}){{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </td>
                            <td class="py-4 px-4 text-center text-green-400 font-bold">Rs. {{ number_format($order->total_amount, 2) }}</td>
                            <td class="py-4 px-4 text-center text-gray-500">{{ $order->updated_at->format('M d, g:i A') }}</td>
                            <td class="py-4 px-4 text-center">
                                <span class="bg-green-950 text-green-400 border border-green-800 text-xs px-3 py-1 rounded-full font-bold tracking-wide uppercase">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-500">No completed orders found in records.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $completedOrders->links() }}
        </div>
    </div>
@endsection