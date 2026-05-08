@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0a0a0a] text-white p-8 font-sans">
    <div class="max-w-2xl mx-auto">
        {{-- Header --}}
        <div class="mb-12 border-b border-gray-800 pb-6">
            <h1 class="text-4xl font-black tracking-tighter text-white uppercase italic">
                Edit <span class="text-red-600">Showtime</span>
            </h1>
            <p class="text-gray-500 text-sm mt-2 tracking-widest uppercase">Modify Schedule Parameters</p>
        </div>

        {{-- Trigger Error Alert (The Safety Lock Message) --}}
        @if($errors->has('error'))
            <div class="mb-6 p-4 bg-red-600/10 border border-red-600/50 text-red-500 rounded-2xl flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0-6V9m0 12a9 9 0 110-18 9 9 0 010 18z" />
                </svg>
                <span class="font-bold uppercase text-xs tracking-tight">{{ $errors->first('error') }}</span>
            </div>
        @endif

        <div class="bg-[#111] rounded-3xl border border-white/5 p-8 shadow-2xl">
            <form action="{{ route('schedules.update', $schedule->schedule_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    {{-- Read-only Movie Title --}}
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 text-zinc-500">Movie Title</label>
                        <input type="text" value="{{ $schedule->movie->movie_title }}" 
                            class="w-full bg-black/40 border border-white/5 rounded-xl px-4 py-3 text-gray-400 font-bold uppercase italic cursor-not-allowed" disabled>
                        <p class="text-[9px] text-zinc-600 mt-2 tracking-tighter uppercase italic">*Movie cannot be changed once scheduled.</p>
                    </div>

                    {{-- Show DateTime --}}
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Show Date & Time</label>
                        <input type="datetime-local" name="show_datetime" 
                            value="{{ \Carbon\Carbon::parse($schedule->show_datetime)->format('Y-m-d\TH:i') }}"
                            class="w-full bg-zinc-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600 focus:ring-0 transition-all">
                    </div>

                    {{-- Ticket Price --}}
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Base Ticket Price (₱)</label>
                        <input type="number" step="0.01" name="base_ticket_price" 
                            value="{{ $schedule->base_ticket_price }}"
                            class="w-full bg-zinc-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600 focus:ring-0 transition-all font-mono">
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-4 pt-4">
                        <a href="{{ route('schedules.index') }}" 
                            class="flex-1 text-center py-4 bg-zinc-800 hover:bg-zinc-700 text-gray-400 font-black uppercase text-xs tracking-widest rounded-xl transition-all">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="flex-1 py-4 bg-red-600 hover:bg-red-700 text-white font-black uppercase text-xs tracking-widest rounded-xl shadow-lg shadow-red-600/20 transition-all">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection