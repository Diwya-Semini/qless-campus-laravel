<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders - Q-Less</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="refresh" content="15"> 
</head>
<body class="bg-[#0f0f12] text-gray-100 font-sans p-6 min-h-screen">

    <div class="max-w-2xl mx-auto">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">My Queues</h1>
            <a href="{{ route('student.menu') }}" class="text-orange-500 hover:text-white transition">← Back to Menu</a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-900/30 border border-green-800 text-green-400 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="text-center text-gray-500 py-12 bg-[#16161a] rounded-2xl border border-gray-800">
                You have no active orders.
            </div>
        @else
            @foreach($orders as $order)
                @php
                    $isReady = $order->status === 'ready';
                    $isCompleted = $order->status === 'completed';
                    
                    // Tailwind dynamic classes
                    $borderColor = $isReady ? 'border-green-500 shadow-[0_0_15px_rgba(34,197,94,0.15)]' : 'border-gray-800';
                    $bgColor = $isCompleted ? 'bg-[#121215]' : 'bg-[#1a1a1a]';
                    $badgeColor = $isReady ? 'text-green-400 bg-green-400/10 border-green-400/30' : 
                                 ($isCompleted ? 'text-gray-400 bg-gray-400/10 border-gray-400/30' : 'text-orange-400 bg-orange-400/10 border-orange-400/30');
                @endphp

                <div class="mb-6 p-6 rounded-2xl border transition-all duration-500 {{ $bgColor }} {{ $borderColor }}">
                    
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-xl font-bold {{ $isCompleted ? 'text-gray-500' : 'text-white' }}">Order #{{ $order->id }}</h2>
                            @if(!$isCompleted)
                                <p class="mt-1 font-semibold {{ $isReady ? 'text-green-400' : 'text-orange-400' }}">
                                    Queue Position: {{ $order->queue_number }}
                                </p>
                            @endif
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase border tracking-wider {{ $badgeColor }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    <p class="text-gray-400 text-sm mb-4">Total: Rs. {{ number_format($order->total_amount, 2) }}</p>

                    @if($isReady && $order->ticket_number)
                        <div class="mt-6 border-t border-gray-800 pt-6 text-center">
                            <p class="text-green-400 text-xs font-bold tracking-[0.2em] mb-2">SHOW THIS CODE AT COUNTER</p>
                            <div class="inline-block bg-green-400/10 border border-green-400/20 rounded-xl px-12 py-4">
                                <span class="text-5xl font-black text-green-400 tracking-[0.3em]">{{ $order->ticket_number }}</span>
                            </div>
                        </div>
                    @endif

                </div>
            @endforeach
        @endif
    </div>

</body>
</html>