@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-black text-white py-12 px-4">
    <div class="max-w-5xl mx-auto">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-2">
                <div class="p-1.5 bg-red-600/20 rounded-md">
                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <span class="text-red-600 text-[10px] font-black uppercase tracking-widest">Ticket Management</span>
            </div>
            <h1 class="text-4xl font-bold tracking-tight uppercase mb-4">Booked Tickets</h1>
            <p class="text-zinc-500 text-sm max-w-2xl">View and manage all ticket bookings. Upcoming tickets can be edited or cancelled, while past tickets are archived for records.</p>
        </div>

        {{-- Filters (Visual Only) --}}
        <div class="flex gap-2 mb-8">
            <button class="px-4 py-1.5 bg-red-600 text-white text-xs font-bold rounded-md">All Tickets ({{ $tickets->count() }})</button>
            <button class="px-4 py-1.5 bg-zinc-900 text-zinc-400 text-xs font-bold rounded-md hover:bg-zinc-800">Upcoming</button>
            <button class="px-4 py-1.5 bg-zinc-900 text-zinc-400 text-xs font-bold rounded-md hover:bg-zinc-800">Past Shows</button>
        </div>

        {{-- Tickets List --}}
        <div class="space-y-4">
            @forelse($tickets as $bookingId => $group)
                @php 
                    $first = $group->first();
                    $isPast = \Carbon\Carbon::parse($first->show_datetime)->isPast();
                @endphp

                <div class="bg-zinc-900/50 border border-white/5 rounded-2xl overflow-hidden flex flex-col md:flex-row group hover:border-white/10 transition-all">
                    
                    {{-- Left: Ticket Code Column --}}
                    <div class="bg-zinc-900 p-8 flex flex-col items-center justify-center border-r border-dashed border-white/10 min-w-[180px]">
                        <div class="p-3 bg-red-600/10 rounded-xl mb-3">
                             <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest">{{ $first->unique_ticket_code }}</span>
                    </div>

                    {{-- Center: Info Columns --}}
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
                                <span class="px-1.5 py-0.5 border border-zinc-700 text-zinc-500 text-[8px] font-bold rounded">PG-13</span>
                                <span class="text-zinc-500 text-[10px] font-medium italic">Cinema Movie</span>
                            </div>
                        </div>

                        {{-- Date & Theater --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 text-zinc-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[9px] font-bold uppercase tracking-widest">Date & Time</span>
                                </div>
                                <p class="text-xs font-bold">{{ \Carbon\Carbon::parse($first->show_datetime)->format('M d, Y') }}</p>
                                <p class="text-[10px] text-zinc-400 font-medium">{{ \Carbon\Carbon::parse($first->show_datetime)->format('H:i') }}</p>
                            </div>

                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 text-zinc-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="text-[9px] font-bold uppercase tracking-widest">Theater & Seats</span>
                                </div>
                                <p class="text-xs font-bold">{{ $first->cinema_name }}</p>
                                <p class="text-[10px] text-red-600 font-bold italic">{{ $group->pluck('seat_label')->implode(', ') }}</p>
                            </div>
                        </div>

                        {{-- Customer --}}
                        <div class="space-y-1">
                            <div class="flex items-center gap-1.5 text-zinc-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="text-[9px] font-bold uppercase tracking-widest">Customer</span>
                            </div>
                            <p class="text-xs font-bold">{{ $first->customer_name }}</p>
                            <p class="text-[10px] text-zinc-500 font-medium truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    {{-- Right: Price & Actions --}}
                    <div class="p-8 border-l border-white/5 bg-zinc-900/30 min-w-[200px] flex flex-col justify-between">
                        <div class="text-right">
                            <p class="text-[9px] text-zinc-600 font-black uppercase tracking-widest mb-1">Total Amount</p>
                            <p class="text-2xl font-bold">${{ number_format($group->sum('price_locked'), 2) }}</p>
                            <p class="text-[10px] text-zinc-500">Purchased: {{ \Carbon\Carbon::parse($first->date_purchased)->format('M d') }}</p>
                        </div>

                        <div class="mt-6 space-y-2">
                            @if(!$isPast)
                                <a href="{{ route('admin.tickets.edit', $bookingId) }}" class="w-full py-2 bg-white/5 border border-white/10 rounded-lg text-[10px] font-bold uppercase tracking-tighter flex items-center justify-center gap-2 hover:bg-red-600 transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    Edit Ticket
                                </a>
                                
                                <form action="{{ route('admin.tickets.delete', $bookingId) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel and delete this entire booking? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-2 bg-transparent text-zinc-500 border border-zinc-800 rounded-lg text-[10px] font-bold uppercase tracking-tighter flex items-center justify-center gap-2 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Cancel Ticket
                                </button>
                                </form>
                            @else
                                <p class="text-[10px] text-zinc-700 font-bold italic text-center">This ticket cannot be modified</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-zinc-900/20 rounded-3xl border border-dashed border-white/10">
                    <p class="text-zinc-600 font-bold uppercase tracking-widest">No tickets found in your history</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection