@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-end px-12 lg:px-32 bg-cover bg-center" 
     style="background-image: linear-gradient(to right, rgba(11,11,11,0.9), rgba(11,11,11,0.2)), url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=2070&auto=format&fit=crop');">
    
    <div class="w-full max-w-md bg-white/5 backdrop-blur-xl p-10 rounded-[40px] border border-white/10 shadow-2xl mt-20 mb-10">
        
        <div class="mb-8">
            <h1 class="text-4xl font-black uppercase tracking-tighter text-white">Create Account</h1>
            <p class="text-gray-400 text-sm mt-2">Join Cinema Z to start booking</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Full Name</label>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                    placeholder="John Doe"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#E21B22] focus:ring-0 transition">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required 
                    placeholder="your@email.com"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#E21B22] focus:ring-0 transition">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Create a password"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#E21B22] focus:ring-0 transition">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required 
                    placeholder="Repeat password"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-[#E21B22] focus:ring-0 transition">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="w-full bg-[#E21B22] hover:bg-red-700 text-white font-black py-4 rounded-xl uppercase tracking-widest transition transform hover:scale-[1.02] mt-4">
                Register Now
            </button>

            <p class="text-center text-sm text-gray-500 pt-2">
                Already have an account? <a href="{{ route('login') }}" class="text-[#E21B22] font-bold hover:underline">Log in</a>
            </p>
        </form>
    </div>
</div>
@endsection