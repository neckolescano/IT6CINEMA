@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    {{-- Progress Tracker --}}
    @include('partials.stepper', ['currentStep' => 4])

    <div class="flex justify-between items-center mb-8">
        <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-zinc-500 hover:text-white transition font-bold uppercase text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Back to Seats
        </a>
    </div>

    <form action="{{ route('tickets.store') }}" method="POST" id="paymentForm">
        @csrf
        {{-- Hidden Data from previous step --}}
        <input type="hidden" name="schedule_id" value="{{ request('schedule_id') }}">
        <input type="hidden" name="seats" value="{{ request('selected_seats') }}">
        <input type="hidden" name="amount" value="{{ request('total_price') }}">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- Left: Payment Form Area --}}
            <div class="lg:col-span-7 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="bg-red-600 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    </div>
                    <h2 class="text-3xl font-black uppercase italic text-white">Payment Details</h2>
                </div>

                {{-- Payment Method Selection --}}
                <div>
                    <h3 class="text-lg font-bold mb-4 text-white">Select Payment Method</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" name="payment_method" value="card" checked onclick="toggleFields('card')" class="peer hidden">
                            <div class="border-2 border-zinc-800 bg-zinc-900/40 p-6 rounded-2xl flex flex-col items-center gap-3 cursor-pointer peer-checked:border-red-600 peer-checked:bg-red-600/5 transition">
                                <span class="text-xl">💳</span>
                                <p class="text-[10px] font-black uppercase text-white">Credit / Debit Card</p>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" name="payment_method" value="ewallet" onclick="toggleFields('ewallet')" class="peer hidden">
                            <div class="border-2 border-zinc-800 bg-zinc-900/40 p-6 rounded-2xl flex flex-col items-center gap-3 cursor-pointer peer-checked:border-red-600 peer-checked:bg-red-600/5 transition">
                                <span class="text-xl">👛</span>
                                <p class="text-[10px] font-black uppercase text-white">E-Wallet (GCash/Maya)</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Dynamic Input Sections --}}
                <div class="space-y-6">
                    {{-- Card Section --}}
                    <div id="card-section" class="space-y-6 transition-all duration-300">
                        <h3 class="text-lg font-bold text-red-600 uppercase tracking-widest text-xs">Card Information</h3>
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase mb-2">Card Network</label>
                            <select name="card_network" class="w-full bg-zinc-900/60 border border-zinc-800 rounded-xl px-6 py-4 text-white focus:border-red-600 outline-none transition">
                                <option value="Visa">Visa</option>
                                <option value="Mastercard">Mastercard</option>
                                <option value="JCB">JCB</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase mb-2">Authorization Code / Card Number</label>
                            <input type="text" name="authorization_code" placeholder="Enter card authorization code" class="card-input w-full bg-zinc-900/60 border border-zinc-800 rounded-xl px-6 py-4 text-white focus:border-red-600 outline-none transition">
                        </div>
                    </div>

                    {{-- E-Wallet Section (Hidden by Default) --}}
                    <div id="ewallet-section" class="hidden space-y-6 transition-all duration-300">
                        <h3 class="text-lg font-bold text-red-600 uppercase tracking-widest text-xs">E-Wallet Information</h3>
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase mb-2">Provider Name</label>
                            <select name="provider_name" class="w-full bg-zinc-900/60 border border-zinc-800 rounded-xl px-6 py-4 text-white focus:border-red-600 outline-none transition">
                                <option value="GCash">GCash</option>
                                <option value="Maya">Maya</option>
                                <option value="GrabPay">GrabPay</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase mb-2">Reference Number</label>
                            <input type="text" name="reference_number" placeholder="REF #123456789" class="wallet-input w-full bg-zinc-900/60 border border-zinc-800 rounded-xl px-6 py-4 text-white focus:border-red-600 outline-none transition">
                        </div>
                    </div>
                </div>

                <p class="text-[10px] text-zinc-500 flex items-center gap-2">
                    🔒 Secure encrypted payment. Your data is processed following PCI DSS standards.
                </p>

                <button type="submit" class="w-full py-5 bg-[#E21B22] hover:bg-red-700 text-white font-black uppercase tracking-widest rounded-2xl transition shadow-[0_10px_20px_rgba(226,27,34,0.3)]">
                    Confirm & Pay ₱{{ number_format(request('total_price'), 2) }}
                </button>
            </div>

            {{-- Right Sidebar --}}
            <div class="lg:col-span-5">
                <div class="bg-zinc-900/40 border border-white/5 rounded-[40px] p-8 space-y-8 sticky top-8">
                    <div class="bg-black/40 rounded-3xl p-6 border border-red-600/20 text-center">
                        <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest mb-1">Time Remaining</p>
                        <p id="countdown" class="text-5xl font-black tracking-tighter text-white">10:00</p>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-white">Booking Summary</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-bold text-zinc-500 uppercase">Movie</p>
                                <p class="text-2xl font-black uppercase italic leading-none text-white">{{ $movie->title }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-zinc-500 uppercase">Seats Selected</p>
                                <p class="text-sm font-bold text-zinc-200">{{ request('selected_seats') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-white/10 pt-6 flex justify-between items-baseline">
                        <span class="text-xl font-black uppercase italic text-white">Total</span>
                        <span class="text-3xl font-black text-red-600">₱{{ number_format(request('total_price'), 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Toggle Payment Fields Logic
    function toggleFields(method) {
        const cardSection = document.getElementById('card-section');
        const walletSection = document.getElementById('ewallet-section');
        const cardInputs = document.querySelectorAll('.card-input');
        const walletInputs = document.querySelectorAll('.wallet-input');

        if (method === 'card') {
            cardSection.classList.remove('hidden');
            walletSection.classList.add('hidden');
            cardInputs.forEach(i => i.required = true);
            walletInputs.forEach(i => i.required = false);
        } else {
            cardSection.classList.add('hidden');
            walletSection.classList.remove('hidden');
            cardInputs.forEach(i => i.required = false);
            walletInputs.forEach(i => i.required = true);
        }
    }

    // 10 Minute Countdown Logic
    let timeLimit = 10 * 60;
    const display = document.querySelector('#countdown');
    const backUrl = "{{ route('movies.seats', $movie->movie_id) }}?schedule_id={{ request('schedule_id') }}";

    const startTimer = () => {
        const timer = setInterval(() => {
            let minutes = Math.floor(timeLimit / 60);
            let seconds = timeLimit % 60;
            display.textContent = `${minutes < 10 ? '0' + minutes : minutes}:${seconds < 10 ? '0' + seconds : seconds}`;

            if (timeLimit <= 0) {
                clearInterval(timer);
                alert("Time's up! Your seat reservation has expired.");
                window.location.href = backUrl;
            }
            if (timeLimit < 60) display.classList.add('text-red-600');
            timeLimit--;
        }, 1000);
    };

    window.onload = () => {
        startTimer();
        toggleFields('card'); // Initialize view
    };
</script>
@endsection