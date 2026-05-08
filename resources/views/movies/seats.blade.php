@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    {{-- Navigation --}}
    <div class="flex justify-between items-center mb-8">
        <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-zinc-500 hover:text-white transition font-bold uppercase text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Back
        </a>
        <a href="{{ route('movies.catalog') }}" class="flex items-center gap-2 text-zinc-500 hover:text-red-600 transition font-bold uppercase text-xs">
            Cancel Booking <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </a>
    </div>

    @include('partials.stepper', ['currentStep' => 3])

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-12">
        {{-- Left: Seat Selection --}}
        <div class="lg:col-span-8 bg-zinc-900/40 p-8 rounded-3xl border border-white/5">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-red-600/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <h2 class="text-xl font-bold text-white">Select Your Seats</h2>
            </div>
            
            <p class="text-zinc-500 mb-8">{{ $movie->title }} • {{ \Carbon\Carbon::parse($schedule->show_datetime)->format('M d • h:i A') }}</p>

            {{-- Controls --}}
            <div class="flex items-center gap-4 mb-12 p-4 bg-zinc-950/50 rounded-2xl border border-white/5 w-fit">
                <span class="text-xs font-bold text-zinc-400 uppercase">Number of Tickets:</span>
                <input type="number" id="ticketLimit" value="1" min="1" max="10" class="bg-zinc-900 border border-white/10 text-white rounded-xl px-3 py-2 w-16 focus:border-red-600 outline-none transition">
                <button type="button" onclick="autoSelectSeats()" class="px-6 py-2 bg-zinc-800 hover:bg-zinc-700 text-white text-xs font-black uppercase rounded-xl transition">Auto Select Seats</button>
            </div>

            {{-- Screen --}}
            <div class="relative mb-16">
                <div class="w-full bg-gradient-to-b from-zinc-700 to-transparent h-1 rounded-full shadow-[0_-10px_40px_rgba(255,255,255,0.2)]"></div>
                <p class="text-center text-[10px] text-zinc-600 font-black tracking-[0.8em] uppercase mt-4">Screen</p>
            </div>

            {{-- Dynamic Seat Map with Center Hallway --}}
            <div class="space-y-4 mb-12 flex flex-col items-center">
                @php $groupedSeats = $allSeats->groupBy('seat_row'); @endphp

                @foreach($groupedSeats as $rowLabel => $seatsInRow)
                    @php
                        $rowSeatsArray = $seatsInRow->values(); 
                        $halfCount = ceil($rowSeatsArray->count() / 2);
                        $leftSide = $rowSeatsArray->slice(0, $halfCount);
                        $rightSide = $rowSeatsArray->slice($halfCount);
                    @endphp

                    <div class="flex items-center justify-center gap-4 w-full">
                        <span class="text-[10px] font-black text-zinc-700 w-6 text-right uppercase tracking-tighter">{{ $rowLabel }}</span>
                        
                        <div class="flex items-center">
                            {{-- Left Side --}}
                            <div class="flex gap-2">
                                @foreach($leftSide as $seat)
                                    @php
                                        $seatLabel = $seat->seat_row . $seat->seat_number;
                                        $isOccupied = in_array($seatLabel, $occupiedSeats);
                                    @endphp
                                    <button type="button"
                                        {{ $isOccupied ? 'disabled' : '' }}
                                        data-seat-id="{{ $seatLabel }}"
                                        onclick="toggleSeat(this, '{{ $seatLabel }}')"
                                        class="seat-item seat-btn transition-all duration-200 w-9 h-9 rounded-xl flex items-center justify-center text-[10px] font-black border
                                        {{ $isOccupied 
                                            ? 'bg-zinc-800 text-zinc-600 cursor-not-allowed border-white/5' 
                                            : 'border-red-600/20 bg-zinc-900/50 text-zinc-400 hover:border-red-600 hover:text-white hover:scale-110 shadow-lg' 
                                        }}">
                                        {{ $seat->seat_number }}
                                    </button>
                                @endforeach
                            </div>

                            {{-- Hallway --}}
                            <div class="w-12 h-10 flex items-center justify-center">
                                <div class="w-[1px] h-4 bg-zinc-800/30"></div>
                            </div>

                            {{-- Right Side --}}
                            <div class="flex gap-2">
                                @foreach($rightSide as $seat)
                                    @php
                                        $seatLabel = $seat->seat_row . $seat->seat_number;
                                        $isOccupied = in_array($seatLabel, $occupiedSeats);
                                    @endphp
                                    <button type="button"
                                        {{ $isOccupied ? 'disabled' : '' }}
                                        data-seat-id="{{ $seatLabel }}"
                                        onclick="toggleSeat(this, '{{ $seatLabel }}')"
                                        class="seat-item seat-btn transition-all duration-200 w-9 h-9 rounded-xl flex items-center justify-center text-[10px] font-black border
                                        {{ $isOccupied 
                                            ? 'bg-zinc-800 text-zinc-600 cursor-not-allowed border-white/5' 
                                            : 'border-red-600/20 bg-zinc-900/50 text-zinc-400 hover:border-red-600 hover:text-white hover:scale-110 shadow-lg' 
                                        }}">
                                        {{ $seat->seat_number }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <span class="text-[10px] font-black text-zinc-700 w-6 text-left uppercase tracking-tighter">{{ $rowLabel }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Legend --}}
            <div class="flex justify-center gap-8 pt-8 border-t border-white/5">
                <div class="flex items-center gap-2 text-[10px] font-bold text-zinc-500 uppercase">
                    <div class="w-4 h-4 border border-red-600/50 rounded-md"></div> Available
                </div>
                <div class="flex items-center gap-2 text-[10px] font-bold text-zinc-500 uppercase">
                    <div class="w-4 h-4 bg-red-600 rounded-md shadow-[0_0_10px_rgba(220,38,38,0.5)]"></div> Selected
                </div>
                <div class="flex items-center gap-2 text-[10px] font-bold text-zinc-500 uppercase">
                    <div class="w-4 h-4 bg-orange-500 rounded-md"></div> Locked
                </div>
                <div class="flex items-center gap-2 text-[10px] font-bold text-zinc-500 uppercase">
                    <div class="w-4 h-4 bg-zinc-800 rounded-md"></div> Taken
                </div>
            </div>
        </div>

        {{-- Right: Booking Summary --}}
        <div class="lg:col-span-4">
            <div class="bg-zinc-900/40 p-8 rounded-3xl border border-white/5 sticky top-8">
                <h3 class="text-xl font-bold text-white mb-8">Booking Summary</h3>
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest mb-1">Movie</p>
                        <p class="text-white font-bold text-lg leading-tight">{{ $movie->title }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest mb-1">Seats</p>
                        <p id="selectedSeatsList" class="text-white font-bold italic text-lg">No seats selected</p>
                    </div>
                </div>
                <div class="my-8 pt-8 border-t border-zinc-800">
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-zinc-400 font-bold">Tickets (<span id="ticketQty">0</span>)</p>
                        <p class="text-white font-bold">₱{{ number_format($schedule->base_ticket_price, 2) }} ea.</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-white text-xl font-black">Total</p>
                        <p class="text-red-600 text-2xl font-black" id="totalDisplay">₱0.00</p>
                    </div>
                </div>
                <form action="{{ route('movies.payment') }}" method="GET">
                    <input type="hidden" name="schedule_id" value="{{ $schedule->schedule_id }}">
                    <input type="hidden" name="selected_seats" id="seatsInput">
                    <input type="hidden" name="total_price" id="totalInput">
                    <button type="submit" id="continueBtn" disabled class="w-full py-4 bg-zinc-800 text-zinc-500 font-black uppercase rounded-2xl cursor-not-allowed transition-all">
                        Select at least one seat
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    window.TICKET_PRICE = parseFloat("{{ $schedule->base_ticket_price }}") || 0;
    window.selectedSeats = [];

    // CSS variables to keep JavaScript synced with your Legend
    const classes = {
        available: ['bg-zinc-900/50', 'text-zinc-400', 'border-red-600/20'],
        selected: ['bg-red-600', 'text-white', 'border-red-600', 'shadow-[0_0_10px_rgba(220,38,38,0.5)]'],
        locked: 'bg-orange-500',
        taken: 'bg-zinc-800'
    };

    window.toggleSeat = function(element, seatId) {
        // Prevent action on Taken or Locked
        if (element.classList.contains(classes.taken) || element.classList.contains(classes.locked)) return;

        const ticketLimit = parseInt(document.getElementById('ticketLimit').value) || 1;

        if (window.selectedSeats.includes(seatId)) {
            window.selectedSeats = window.selectedSeats.filter(s => s !== seatId);
            element.classList.remove(...classes.selected);
            element.classList.add(...classes.available);
        } else {
            if (window.selectedSeats.length >= ticketLimit) {
                alert("Limit reached! Selection is capped at " + ticketLimit + " seats.");
                return;
            }
            window.selectedSeats.push(seatId);
            element.classList.remove(...classes.available);
            element.classList.add(...classes.selected);
        }
        updateSummary();
    }

    window.autoSelectSeats = function() {
        const ticketLimit = parseInt(document.getElementById('ticketLimit').value) || 1;
        const availableSeats = document.querySelectorAll(`.seat-item:not([disabled]):not(.${classes.locked})`);
        
        // Reset non-locked seats
        document.querySelectorAll('.seat-item').forEach(s => {
            if (!s.disabled && !s.classList.contains(classes.locked)) {
                s.classList.remove(...classes.selected);
                s.classList.add(...classes.available);
            }
        });
        window.selectedSeats = [];

        for (let i = 0; i < Math.min(ticketLimit, availableSeats.length); i++) {
            const seat = availableSeats[i];
            const sid = seat.getAttribute('data-seat-id');
            window.selectedSeats.push(sid);
            seat.classList.remove(...classes.available);
            seat.classList.add(...classes.selected);
        }
        updateSummary();
    }

    function updateSummary() {
        const count = window.selectedSeats.length;
        const total = (count * window.TICKET_PRICE);
        document.getElementById('selectedSeatsList').innerText = count > 0 ? window.selectedSeats.join(', ') : 'No seats selected';
        document.getElementById('ticketQty').innerText = count;
        document.getElementById('totalDisplay').innerText = '₱' + total.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById('seatsInput').value = window.selectedSeats.join(', ');
        document.getElementById('totalInput').value = total.toFixed(2);

        const btn = document.getElementById('continueBtn');
        if (count > 0) {
            btn.disabled = false;
            btn.classList.replace('bg-zinc-800', 'bg-red-600');
            btn.classList.replace('text-zinc-500', 'text-white');
            btn.innerText = "Continue to Payment";
        } else {
            btn.disabled = true;
            btn.classList.replace('bg-red-600', 'bg-zinc-800');
            btn.classList.replace('text-white', 'text-zinc-500');
            btn.innerText = "Select at least one seat";
        }
    }
</script>
@endsection