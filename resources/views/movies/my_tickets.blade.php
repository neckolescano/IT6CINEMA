@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-black text-white py-12 px-4">
    <div class="max-w-5xl mx-auto">
        
        {{-- Header Section --}}
        <div class="mb-10">
            <div class="flex items-center gap-2 mb-2">
                <div class="p-1.5 bg-red-600/20 rounded-md">
                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <span class="text-red-600 text-[10px] font-black uppercase tracking-widest">Customer Portal</span>
            </div>
            <h1 class="text-4xl font-bold tracking-tight uppercase mb-2">My Ticket History</h1>
            <p class="text-zinc-500 text-sm italic">Showing your confirmed bookings and past movie screenings.</p>
        </div>

        {{-- Tickets List --}}
        <div class="space-y-4">
            @forelse($tickets as $bookingId => $group)
                @php 
                    $first = $group->first();
                    $isPast = \Carbon\Carbon::parse($first->show_datetime)->isPast();
                @endphp

                <div class="bg-zinc-900/50 border border-white/5 rounded-2xl overflow-hidden flex flex-col md:flex-row group transition-all">
                    
                    {{-- Left: Visual Stub --}}
                    <div class="bg-zinc-900 p-8 flex flex-col items-center justify-center border-r border-dashed border-white/10 min-w-[180px]">
                        <div class="p-3 bg-red-600/10 rounded-xl mb-3">
                             <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <span class="text-[9px] text-zinc-500 font-bold uppercase tracking-[0.2em] mb-1">Booking Ref</span>
                        <span class="text-xs text-white font-black uppercase tracking-widest">BKG-{{ $bookingId }}</span>
                    </div>

                    {{-- Center: Ticket Details --}}
                    <div class="flex-grow p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Movie & Badge --}}
                        <div class="col-span-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h2 class="text-xl font-bold uppercase tracking-tight">{{ $first->movie_title }}</h2>
                                @if($isPast)
                                    <span class="px-2 py-0.5 rounded text-[8px] font-black bg-zinc-800 text-zinc-500 uppercase">Past Show</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[8px] font-black bg-green-500/10 text-green-500 uppercase">Active</span>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <span class="px-1.5 py-0.5 border border-zinc-700 text-zinc-500 text-[8px] font-bold rounded">CONFIRMED</span>
                                <span class="text-zinc-500 text-[10px] font-medium italic">Cinema Z Digital Ticket</span>
                            </div>
                        </div>

                        {{-- Date & Location --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 text-zinc-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[9px] font-bold uppercase tracking-widest">Schedule</span>
                                </div>
                                <p class="text-xs font-bold">{{ \Carbon\Carbon::parse($first->show_datetime)->format('M d, Y') }}</p>
                                <p class="text-[10px] text-zinc-400 font-medium">{{ \Carbon\Carbon::parse($first->show_datetime)->format('h:i A') }}</p>
                            </div>

                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 text-zinc-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="text-[9px] font-bold uppercase tracking-widest">Seats</span>
                                </div>
                                <p class="text-xs font-bold">{{ $first->cinema_name }}</p>
                                <p class="text-[10px] text-red-600 font-bold italic">{{ $group->pluck('seat_label')->implode(', ') }}</p>
                            </div>
                        </div>

                        {{-- Ticket Codes --}}
                        <div class="space-y-2">
                            <div class="flex items-center gap-1.5 text-zinc-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-[9px] font-bold uppercase tracking-widest">Validation Codes</span>
                            </div>
                            <div class="flex flex-wrap gap-1">
                                @foreach($group as $seat)
                                    <span class="px-2 py-0.5 bg-zinc-800 text-zinc-400 text-[8px] font-black rounded uppercase border border-white/5">
                                        {{ $seat->unique_ticket_code }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Right: Total Amount --}}
                    <div class="p-8 border-l border-white/5 bg-zinc-900/30 min-w-[200px] flex flex-col justify-center text-right">
                        <p class="text-[9px] text-zinc-600 font-black uppercase tracking-widest mb-1">Total Amount</p>
                        <p class="text-2xl font-black text-white">₱{{ number_format($group->sum('price_locked'), 2) }}</p>
                        <p class="text-[10px] text-zinc-500 mt-1 uppercase tracking-tighter">Paid via {{ $first->customer_name }}</p>
                        <div class="mt-4 pt-4 border-t border-white/5">
                             <p class="text-[10px] text-zinc-500">Purchased on:</p>
                             <p class="text-[10px] text-zinc-400 font-bold">{{ \Carbon\Carbon::parse($first->date_purchased)->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-24 bg-zinc-900/20 rounded-3xl border border-dashed border-white/10">
                    <p class="text-zinc-600 font-bold uppercase tracking-widest italic">You haven't booked any tickets yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection