@extends('layouts.app') {{-- This uses your new master layout --}}

@section('content')
<div class="min-h-screen flex items-center justify-end px-12 lg:px-32 bg-cover bg-center" 
     style="background-image: linear-gradient(to right, rgba(11,11,11,0.9), rgba(11,11,11,0.2)), url('{{ asset('images/loginbg.png') }}');">
    
    <div class="w-full max-w-md bg-white/5 backdrop-blur-xl p-10 rounded-[40px] border border-white/10 shadow-2xl">
        
        <div class="mb-8">
            <h1 class="text-4xl font-black uppercase tracking-tighter text-white">Welcome Back</h1>
            <p class="text-gray-400 text-sm mt-2">Sign in to book your tickets</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                    placeholder="your@email.com"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#E21B22] focus:ring-0 transition">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required 
                        placeholder="Enter your password"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#E21B22] focus:ring-0 transition">
                    <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white">👁️</button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center text-gray-400">
                    <input type="checkbox" name="remember" class="rounded border-gray-800 bg-black text-[#E21B22] focus:ring-[#E21B22]">
                    <span class="ml-2">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-gray-400 hover:text-white transition">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="w-full bg-[#E21B22] hover:bg-red-700 text-white font-black py-4 rounded-xl uppercase tracking-widest transition transform hover:scale-[1.02]">
                Log In
            </button>

            <p class="text-center text-sm text-gray-500">
                Don't have an account? <a href="{{ route('register') }}" class="text-[#E21B22] font-bold hover:underline">Sign up</a>
            </p>

            <div class="pt-4 border-t border-white/5">
                <p class="text-center text-[10px] text-gray-600 uppercase tracking-widest mb-4">or continue with</p>
                <div class="flex gap-4">
                    <button type="button" class="flex-1 bg-white/5 hover:bg-white/10 border border-white/10 py-3 rounded-xl text-xs font-bold transition">Google</button>
                    <button type="button" class="flex-1 bg-white/5 hover:bg-white/10 border border-white/10 py-3 rounded-xl text-xs font-bold transition">Facebook</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection