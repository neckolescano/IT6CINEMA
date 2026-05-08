@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-black text-white py-12 px-4">
    <div class="max-w-3xl mx-auto">
        
        <div class="mb-8">
            <a href="{{ route('admin.tickets') }}" class="text-red-600 text-[10px] font-black uppercase tracking-widest hover:underline flex items-center gap-2 mb-4">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Back to Tickets
            </a>
            <h1 class="text-4xl font-bold tracking-tight uppercase mb-2">Edit Booking</h1>
            <p class="text-zinc-500 text-sm italic">Modifying Booking ID: #{{ $booking->booking_id }}</p>
        </div>

        <div class="bg-zinc-900/50 border border-white/5 rounded-3xl p-8 shadow-2xl">
            <form action="{{ route('admin.tickets.update', $booking->booking_id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Schedule Selection --}}
                <div class="space-y-2">
                    <label class="text-[10px] text-zinc-500 font-black uppercase tracking-widest ml-1">Change Showtime</label>
                    <select name="schedule_id" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-sm font-bold focus:border-red-600 focus:ring-0 transition-all outline-none">
                        @foreach($schedules as $s)
                            <option value="{{ $s->schedule_id }}" {{ $booking->schedule_id == $s->schedule_id ? 'selected' : '' }}>
                                {{ $s->movie->title }} | {{ \Carbon\Carbon::parse($s->show_datetime)->format('M d - H:i') }} | {{ $s->cinema->cinema_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Selection --}}
                <div class="space-y-2">
                    <label class="text-[10px] text-zinc-500 font-black uppercase tracking-widest ml-1">Booking Status</label>
                    <select name="status" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-sm font-bold focus:border-red-600 focus:ring-0 transition-all outline-none">
                        <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ $booking->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Cancelled" {{ $booking->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                {{-- Visual Info (Read Only) --}}
                <div class="p-4 bg-red-600/5 border border-red-600/10 rounded-2xl flex items-center justify-between">
                    <div>
                        <p class="text-[9px] text-red-600 font-black uppercase tracking-widest">Total Amount</p>
                        <p class="text-xl font-bold">${{ number_format($booking->total_amount, 2) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] text-zinc-600 font-black uppercase tracking-widest italic">Customer</p>
                        <p class="text-sm font-bold">{{ $booking->customerProfile->user->name ?? 'Guest' }}</p>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-red-600/20">
                        Update Booking Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection