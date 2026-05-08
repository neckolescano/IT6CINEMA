@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-5xl font-black uppercase italic mb-2">Movies</h1>
    <p class="text-zinc-500 mb-10 font-bold">Discover and book your favorite movies</p>

    {{-- Filter Bar --}}
    <div class="flex gap-4 mb-16">
        <input type="text" placeholder="Search for movies..." class="bg-zinc-900 border-none rounded-xl px-6 py-4 w-full max-w-md text-white">
        <select class="bg-zinc-900 border-none rounded-xl px-6 py-4 text-zinc-400 font-bold">
            <option>Language</option>
        </select>
        <select class="bg-zinc-900 border-none rounded-xl px-6 py-4 text-zinc-400 font-bold">
            <option>Genre</option>
        </select>
    </div>

    {{-- Now Showing Section --}}
    <section class="mb-20">
        <h2 class="text-3xl font-black uppercase tracking-tight mb-8">Now Showing</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($nowShowing as $movie)
                <div class="group">
                    <div class="relative aspect-[2/3] rounded-2xl overflow-hidden mb-4 shadow-2xl">
                        <img src="{{ asset('posters/' . $movie->poster_url) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
                    </div>
                    <h3 class="text-xl font-black uppercase italic tracking-tighter">{{ $movie->title }}</h3>
                    <p class="text-xs text-zinc-500 font-bold mb-4">{{ $movie->genre }} • {{ $movie->runtime_minutes }}m</p>
                    <a href="{{ route('movies.show', $movie->movie_id) }}" class="block w-full bg-[#E21B22] text-center py-3 rounded-xl font-black uppercase text-xs">Book Now</a>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection