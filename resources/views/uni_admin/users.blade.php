@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-2xl font-semibold tracking-tight text-white">Platform Managers</h1>
            <p class="text-sm text-gray-400 mt-1">Directory of all active SaaS tenant managers and their assigned locations.</p>
        </div>

        <div class="bg-white/[0.02] rounded-2xl border border-white/5 shadow-2xl overflow-hidden backdrop-blur-xl">
            @if($managers->isEmpty())
                <div class="p-12 text-center text-sm text-gray-500">No managers found on the network.</div>
            @else
                <table class="min-w-full divide-y divide-white/5">
                    <thead class="bg-white/[0.02]"><th class="px-6 py-4 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Action</th>
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Manager Profile</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Assigned Outlet</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Campus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($managers as $manager)
                            <tr class="hover:bg-white/[0.02] transition-colors duration-200">
                                
                                <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-gray-700 to-gray-800 text-gray-300 flex items-center justify-center font-medium text-sm mr-4 border border-white/10 shadow-inner">
                                        {{ substr($manager->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm text-gray-200 font-medium">{{ $manager->name }}</span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $manager->email }}</td>
                                
                                @if($manager->canteen)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="text-gray-200">{{ $manager->canteen->name }}</span>
                                        @if($manager->canteen->status === 'pending')
                                            <span class="ml-2 bg-amber-500/10 text-amber-500/90 text-[10px] px-2 py-0.5 rounded-full font-medium tracking-wide border border-amber-500/20">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $manager->canteen->location }}</td>
                                @else
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-400/80 italic">Unassigned</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                @endif
                                
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <form action="{{ route('admin.users.destroy', $manager->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to revoke this manager\'s access? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 font-semibold transition border border-red-500/30 hover:bg-red-500/10 px-3 py-1 rounded-lg text-xs">
                                            Revoke Access
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
@endsection