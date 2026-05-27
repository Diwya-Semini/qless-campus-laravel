<x-app-layout>
<div class="min-h-screen flex flex-col items-center justify-center p-6 bg-[#0B0F19]">
    
    @if (session('status'))
        <div class="mb-6 max-w-md w-full bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-4 flex items-start gap-3 backdrop-blur-xl animate-fade-in">
            <svg class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="text-sm font-bold text-emerald-400">Application Submitted</h4>
                <p class="text-xs text-emerald-400/80 mt-0.5 leading-relaxed">
                    {{ session('status') }}
                </p>
            </div>
        </div>
    @endif

    <div class="bg-white/[0.02] border border-white/5 rounded-3xl p-8 max-w-md w-full text-center backdrop-blur-2xl shadow-2xl">
        <div class="w-16 h-16 bg-orange-500/10 border border-orange-500/20 text-orange-400 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-orange-500/5">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-black text-white tracking-tight">Account Pending Verification</h2>
        <p class="text-gray-400 text-sm mt-2 leading-relaxed">
            Welcome to the QLess Campus network. Your facility profiling dashboard is locked until the university executive team reviews your credentials.
        </p>
    </div>

</div>
</x-app-layout>