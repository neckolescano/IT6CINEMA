@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0a0a0a] text-white p-8 font-sans">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-black tracking-tighter text-white uppercase italic">
                Initialize <span class="text-red-600">Showtime</span>
            </h1>
            <p class="text-gray-500 text-sm mt-2 tracking-widest uppercase">Temporal Grid Configuration</p>
        </div>

        <div class="bg-[#111] rounded-3xl p-10 border border-white/5 shadow-2xl relative overflow-hidden">
            <form action="{{ route('schedules.store') }}" method="POST" class="space-y-8 relative z-10">
                @csrf
                
                <!-- Movie Selection -->
                <div>
                    <label class="block text-[10px] font-black text-gray-500 mb-3 uppercase tracking-widest">Select Movie</label>
                    <select name="movie_id" required 
                            class="w-full bg-[#1a1a1a] border border-gray-800 rounded-2xl p-5 text-white focus:border-red-600 outline-none transition-all appearance-none cursor-pointer">
                        <option value="" disabled selected>Choose a movie from catalog...</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->movie_id }}">{{ $movie->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cinema Selection -->
                <div>
                    <label class="block text-[10px] font-black text-gray-500 mb-3 uppercase tracking-widest">Assign Auditorium</label>
                    <select name="cinema_id" required 
                            class="w-full bg-[#1a1a1a] border border-gray-800 rounded-2xl p-5 text-white focus:border-red-600 outline-none transition-all appearance-none cursor-pointer">
                        <option value="" disabled selected>Assign to theater...</option>
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->cinema_id }}">{{ $cinema->cinema_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Show Datetime and Price -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 mb-3 uppercase tracking-widest">Show Date & Time</label>
                        <!-- Using datetime-local to satisfy the show_datetime field in image_fe22e2.png -->
                        <input type="datetime-local" name="show_datetime" required min="{{ now()->format('Y-m-d\TH:i') }}"
                               class="w-full bg-[#1a1a1a] border border-gray-800 rounded-2xl p-5 text-white focus:border-red-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 mb-3 uppercase tracking-widest">Base Ticket Price ($)</label>
                        <!-- Matches base_ticket_price from your ERD -->
                        <input type="number" name="base_ticket_price" step="0.01" placeholder="15.00" required
                               class="w-full bg-[#1a1a1a] border border-gray-800 rounded-2xl p-5 text-white focus:border-red-600 outline-none">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-black py-5 rounded-2xl uppercase tracking-widest transition-all shadow-[0_10px_20px_rgba(220,38,38,0.2)] active:scale-95">
                        Commit Schedule
                    </button>
                    <a href="{{ route('schedules.index') }}" class="flex-1 bg-[#1a1a1a] hover:bg-[#222] text-white flex items-center justify-center py-5 rounded-2xl font-black uppercase tracking-widest transition-all border border-gray-800">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection