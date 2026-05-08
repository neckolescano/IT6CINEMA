@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    {{-- Top Navigation --}}
    <div class="flex justify-between items-center mb-8">
        <a href="{{ route('movies.catalog') }}" class="flex items-center gap-2 text-zinc-500 hover:text-white transition font-bold uppercase text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Back
        </a>
        <a href="{{ route('movies.catalog') }}" class="flex items-center gap-2 text-zinc-500 hover:text-red-600 transition font-bold uppercase text-xs">
            Cancel Booking <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </a>
    </div>

    {{-- Progress Stepper --}}
    @include('partials.stepper', ['currentStep' => 2])

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-12">
        {{-- 1. Left Sidebar: Movie Info --}}
        <div class="lg:col-span-4 bg-zinc-900/40 p-6 rounded-3xl border border-white/5 h-fit">
            <img src="{{ asset('posters/' . $movie->poster_url) }}" class="w-full rounded-2xl mb-6 shadow-2xl aspect-[2/3] object-cover">
            <h1 class="text-3xl font-black uppercase italic mb-2 text-white">{{ $movie->title }}</h1>
            
            <div class="flex gap-2 text-[10px] font-bold text-zinc-500 mb-6 uppercase tracking-wider">
                <span class="bg-zinc-800 px-2 py-1 rounded text-white border border-white/10">{{ $movie->rating }}</span>
                <span class="py-1">{{ $movie->genre }} • {{ $movie->runtime_minutes }} min • English</span>
            </div>

            <p class="text-zinc-400 text-sm leading-relaxed mb-8 opacity-70">{{ Str::limit($movie->synopsis, 150) }}</p>
            
            <div class="flex items-center gap-2 text-red-600 text-[10px] font-black uppercase tracking-widest border-t border-white/5 pt-6">
                <span>Selected Movie</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        {{-- 2. Right Content: Selection Area --}}
        <div class="lg:col-span-8 space-y-6">
            
            {{-- Date Selection Section --}}
            <div class="bg-zinc-900/40 p-8 rounded-3xl border border-white/5">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2 bg-red-600/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <h2 class="text-xl font-bold text-white">Select Date</h2>
                </div>

                <div class="relative">
                    <div class="flex gap-4 overflow-x-auto pb-6 no-scrollbar">
                        {{-- Logic to generate next 7 days --}}
                        @for($i = 0; $i < 7; $i++)
                            @php $date = \Carbon\Carbon::now()->addDays($i); @endphp
                            <div class="min-w-[85px] p-4 {{ $i == 0 ? 'bg-red-600 shadow-[0_10px_20px_rgba(220,38,38,0.2)]' : 'bg-zinc-950 border border-white/5 opacity-50' }} rounded-2xl text-center cursor-pointer transition-all hover:scale-105">
                                <p class="text-[10px] font-bold uppercase tracking-tighter {{ $i == 0 ? 'text-white' : 'text-zinc-500' }}">{{ $date->format('D') }}</p>
                                <p class="text-2xl font-black text-white my-1">{{ $date->format('j') }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-tighter {{ $i == 0 ? 'text-white' : 'text-zinc-500' }}">{{ $date->format('M') }}</p>
                            </div>
                        @endfor
                    </div>
                    <p class="text-center text-zinc-600 text-[10px] font-bold uppercase tracking-widest mt-2">
                        ‹ Scroll for more dates ›
                    </p>
                </div>
            </div>

            {{-- Showtime Selection Section --}}
            <div class="bg-zinc-900/40 p-8 rounded-3xl border border-white/5">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2 bg-red-600/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h2 class="text-xl font-bold text-white">Select Showtime</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @forelse($movie->schedules as $schedule)
                        <button type="button" 
                            onclick="selectShowtime(this, {{ $schedule->schedule_id }})"
                            class="showtime-btn bg-zinc-950 p-5 rounded-3xl border border-white/5 text-center transition-all hover:bg-zinc-900 group">
                            <p class="font-black text-lg text-white group-hover:text-red-600 transition">
                                {{ \Carbon\Carbon::parse($schedule->show_datetime)->format('h:i A') }}
                            </p>
                            <p class="text-[10px] text-zinc-600 font-bold uppercase tracking-tighter mt-1">Cinema {{ $schedule->cinema_id }}</p>
                        </button>
                    @empty
                        <p class="col-span-full text-zinc-500 text-center py-8 italic">No showtimes available for this date.</p>
                    @endforelse
                </div>
            </div>

            {{-- Navigation Action --}}
            <form action="{{ route('movies.seats', $movie->movie_id) }}" method="GET" id="selectionForm" class="pt-4">
                <input type="hidden" name="schedule_id" id="selected_schedule">
                <button type="submit" id="continueBtn" disabled 
                    class="w-full py-5 bg-zinc-800 text-zinc-500 font-black uppercase tracking-[0.2em] rounded-2xl cursor-not-allowed transition-all duration-300">
                    Please select a showtime
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
function selectShowtime(element, id) {
    // Reset all buttons
    document.querySelectorAll('.showtime-btn').forEach(btn => {
        btn.classList.remove('border-red-600', 'ring-2', 'ring-red-600/50', 'bg-zinc-900');
        btn.classList.add('bg-zinc-950', 'border-white/5');
        btn.querySelector('p').classList.remove('text-red-600');
    });

    // Style the selected button
    element.classList.add('border-red-600', 'ring-2', 'ring-red-600/50', 'bg-zinc-900');
    element.classList.remove('bg-zinc-950', 'border-white/5');
    element.querySelector('p').classList.add('text-red-600');

    // Update hidden input and enable button
    document.getElementById('selected_schedule').value = id;
    const btn = document.getElementById('continueBtn');
    btn.disabled = false;
    btn.classList.remove('bg-zinc-800', 'text-zinc-500', 'cursor-not-allowed');
    btn.classList.add('bg-red-600', 'text-white', 'hover:bg-red-700', 'shadow-lg', 'shadow-red-900/40');
    btn.innerText = 'Continue to Seat Selection';
}
</script>
@endsection