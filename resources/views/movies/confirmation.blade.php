@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    {{-- Progress Tracker - Step 5 (Final) --}}
    @include('partials.stepper', ['currentStep' => 5])

    <div class="bg-zinc-900/40 border border-white/5 rounded-[40px] p-12 text-center mt-10">
        {{-- Success Icon --}}
        <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-zinc-900 text-2xl">✓</div>
        </div>

        <h1 class="text-4xl font-black uppercase italic mb-2">Booking Confirmed!</h1>
        <p class="text-zinc-500 font-bold mb-12">Your tickets have been successfully booked</p>

        {{-- Digital Ticket Summary --}}
        <div class="bg-black/40 border border-white/5 rounded-3xl p-8 text-left relative overflow-hidden">
            <div class="flex justify-between items-start mb-8">
                <div class="flex gap-4">
                    {{-- Dynamic Movie Poster --}}
                    <img src="{{ asset('posters/' . $movie->poster_url) }}" class="w-20 h-28 object-cover rounded-xl shadow-xl">
                    <div>
                        <h2 class="text-2xl font-black uppercase italic leading-none">{{ $booking->movie_title }}</h2>
                        <p class="text-xs text-zinc-500 font-bold mt-1">{{ $movie->genre }} • {{ $movie->rating }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Booking Reference</p>
                    <p class="text-red-600 font-black uppercase tracking-tighter text-xl">{{ $booking->unique_ticket_code }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-y-8 border-t border-white/5 pt-8 mb-8">
                <div>
                    <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-1">Date</p>
                    <p class="font-bold text-zinc-200">{{ $booking->date_purchased }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-1">Time</p>
                    <p class="font-bold text-zinc-200">{{ $booking->show_datetime }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-1">Seats</p>
                    <p class="font-bold text-zinc-200">{{ $booking->seat_label }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-1">Total Amount Paid</p>
                    <p class="font-black text-red-600">₱{{ number_format($booking->price_locked, 2) }}</p>
                </div>
            </div>

            <p class="text-center text-[10px] text-zinc-600 italic border-t border-white/5 pt-6">
                A confirmation email with your tickets has been sent to {{ auth()->user()->email }}
            </p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-4 mt-10">
            <button onclick="window.print()" class="flex-1 py-4 bg-red-600 hover:bg-red-700 text-white font-black uppercase tracking-widest rounded-2xl flex items-center justify-center gap-2 transition">
                🎟 Print Tickets
            </button>
            <a href="{{ route('home') }}" class="flex-1 py-4 bg-zinc-800 hover:bg-zinc-700 text-white font-black uppercase tracking-widest rounded-2xl flex items-center justify-center gap-2 transition">
                🏠 Back to Home
            </a>
        </div>
    </div>

    {{-- Recommendations Section --}}
    <div class="mt-20">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-3xl font-black uppercase italic">You Might Also Like</h3>
            <span class="bg-purple-600/20 text-purple-400 text-[10px] font-black uppercase px-3 py-1 rounded-full border border-purple-500/30">✨ AI Powered</span>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($suggestedMovies as $suggested)
                <a href="{{ route('movies.show', $suggested->movie_id) }}" class="group">
                    {{-- Dynamic Poster Path --}}
                    <img src="{{ asset('posters/' . $suggested->poster_url) }}" 
                        class="w-full aspect-[2/3] object-cover rounded-2xl mb-4 group-hover:scale-105 transition-transform duration-500 shadow-lg">
                    
                    <h4 class="font-bold text-lg uppercase italic text-white">{{ $suggested->title }}</h4>
                    
                    <div class="flex justify-between text-[10px] text-zinc-500 font-bold uppercase">
                        <span>{{ $suggested->genre }}</span>
                        <span class="text-yellow-500">⭐ {{ $suggested->rating }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection