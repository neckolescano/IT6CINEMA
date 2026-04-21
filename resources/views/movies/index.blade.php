@extends('layouts.app')

@section('content')
<div class="relative w-full h-[600px] overflow-hidden rounded-3xl mb-12">
    <img src="/images/hail-mary-hero.jpg" class="absolute inset-0 w-full h-full object-cover" alt="Project Hail Mary">
    
    <div class="absolute inset-0 bg-gradient-to-t from-[#0b0b0b] via-black/20 to-transparent"></div>

    <div class="absolute bottom-16 left-12 max-w-2xl">
        <span class="bg-[#E21B22]/20 text-[#E21B22] px-4 py-1 rounded-full text-xs font-bold uppercase mb-4 inline-block">Now Featured</span>
        <h1 class="text-6xl font-black uppercase tracking-tighter mb-4">Project Hail Mary</h1>
        
        <div class="flex items-center gap-4 text-sm text-gray-300 mb-6 font-semibold">
            <span class="border border-gray-500 px-2 rounded">PG-13</span>
            <span>2h 14min</span>
            <span>•</span>
            <span>2026</span>
        </div>

        <p class="text-gray-400 text-lg mb-8 leading-relaxed">
            A lone astronaut wakes up on a spaceship with no memory of who he is or why he's there. 
            As humanity's last hope, he must piece together his mission to save Earth.
        </p>

        <div class="flex gap-4">
            <button class="bg-[#E21B22] hover:bg-red-700 px-10 py-3 rounded-xl font-bold uppercase transition">Book Now</button>
            <button class="bg-white/10 hover:bg-white/20 backdrop-blur-md px-10 py-3 rounded-xl font-bold uppercase transition">More Info</button>
        </div>
    </div>
</div>

<div class="mb-16">
    <h2 class="text-3xl font-black uppercase tracking-tight mb-8">Now Showing</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        @foreach($nowShowing as $movie)
            <x-movie-card :movie="$movie" type="now-showing" />
        @endforeach
    </div>
</div>

<div class="mb-20">
    <h2 class="text-3xl font-black uppercase tracking-tight mb-8 text-gray-400">Coming Soon</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        @foreach($comingSoon as $movie)
            <x-movie-card :movie="$movie" type="coming-soon" />
        @endforeach
    </div>
</div>
@endsection