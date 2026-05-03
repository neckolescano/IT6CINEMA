@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0a0a0a] text-white p-8 font-sans">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-12 border-b border-gray-800 pb-6 text-center">
            <h1 class="text-4xl font-black tracking-tighter text-white uppercase italic">
                Edit <span class="text-red-600">Infrastructure</span>
            </h1>
            <p class="text-gray-500 text-sm mt-2 tracking-widest uppercase">System Recalibration</p>
        </div>

        <div class="bg-[#111] rounded-3xl p-10 border border-white/5 shadow-2xl relative overflow-hidden">
            <!-- Decorative corner accent -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-600/5 blur-3xl rounded-full -mr-16 -mt-16"></div>

            <form action="{{ route('cinemas.update', ['cinema' => $cinema->cinema_id]) }}" method="POST" class="space-y-8 relative z-10">
                @csrf
                @method('PUT')
                
                <!-- Auditorium Name -->
                <div>
                    <label class="block text-[10px] font-black text-gray-500 mb-3 uppercase tracking-widest">Auditorium Name</label>
                    <input type="text" name="cinema_name" value="{{ old('cinema_name', $cinema->cinema_name) }}" required
                           class="w-full bg-[#1a1a1a] border border-gray-800 rounded-2xl p-5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-all text-lg font-bold">
                </div>

                <!-- Seating Grid Configuration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-black/40 rounded-2xl border border-white/5">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 mb-3 uppercase tracking-widest">Vertical Rows (A-Z)</label>
                        <input type="number" name="num_rows" min="1" max="26" value="{{ old('num_rows', $cinema->seats->unique('seat_row')->count()) }}" required
                               class="w-full bg-[#222] border border-gray-800 rounded-xl p-4 text-white focus:border-red-600 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 mb-3 uppercase tracking-widest">Units Per Row</label>
                        <input type="number" name="seats_per_row" min="1" max="30" value="{{ old('seats_per_row', $cinema->seats->where('seat_row', 'A')->count()) }}" required
                               class="w-full bg-[#222] border border-gray-800 rounded-xl p-4 text-white focus:border-red-600 outline-none transition-all">
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-[9px] text-red-500/70 font-bold uppercase italic tracking-tighter">
                            Warning: Updating seat dimensions will dismantle and regenerate all unit IDs for this auditorium.
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-black py-5 rounded-2xl uppercase tracking-widest transition-all shadow-[0_10px_20px_rgba(220,38,38,0.2)] active:scale-[0.98]">
                        Update System
                    </button>
                    <a href="{{ route('cinemas.index') }}" class="flex-1 bg-[#1a1a1a] hover:bg-[#222] text-white flex items-center justify-center py-5 rounded-2xl font-black uppercase tracking-widest transition-all border border-gray-800">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 text-center">
            <p class="text-[10px] text-gray-700 font-bold uppercase tracking-[0.5em]">CinemaZ Core Infrastructure v2.0</p>
        </div>
    </div>
</div>
@endsection