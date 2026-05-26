@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex justify-between items-end border-b border-white/10 pb-5">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tight">Network Canteens</h1>
                <p class="text-gray-400 mt-1">Manage all campus locations across the SaaS platform.</p>
            </div>
            
            <a href="{{ route('admin.canteen.create') }}" class="px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-400 hover:to-orange-500 rounded-lg shadow-lg shadow-orange-500/20 transition-all duration-200">
                + Add New Canteen
            </a>
        </div>

        @if (session('success'))
            <div class="mb-8 bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-xl text-sm font-medium backdrop-blur-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($canteens as $canteen)
                <div class="bg-white/[0.02] border border-white/5 rounded-2xl p-6 backdrop-blur-xl hover:bg-white/[0.04] transition duration-300 flex flex-col justify-between">
                    
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            @if($canteen->is_open)
                                <span class="bg-green-500/10 text-green-400 border border-green-500/20 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Open</span>
                            @else
                                <span class="bg-red-500/10 text-red-400 border border-red-500/20 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Closed</span>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-white mb-1">{{ $canteen->name }}</h3>
                        <p class="text-sm text-orange-500 font-medium mb-4">{{ $canteen->location }}</p>
                    </div>

                    <div class="mt-4 pt-4 border-t border-white/5 flex justify-between items-center text-xs text-gray-500">
                        <span class="flex items-center gap-1">
                            🕒 {{ $canteen->operating_hours ?? 'Hours unlisted' }}
                        </span>
                        <span>ID: #{{ $canteen->id }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 text-center text-gray-500 bg-white/[0.02] rounded-2xl border border-white/5">
                    No canteens have been deployed on the network yet.
                </div>
            @endforelse
        </div>

    </div>
@endsection