@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Dynamic Hero Section --}}
    @if($nowShowing->count() > 0)
        @php $featured = $nowShowing->first(); @endphp
        <div class="relative w-full h-[600px] overflow-hidden rounded-3xl mb-16 shadow-2xl">
            {{-- Hero Image --}}
            <img src="{{ asset('posters/' . $featured->poster_url) }}" class="absolute inset-0 w-full h-full object-cover object-top" alt="{{ $featured->title }}">
            
            {{-- Dark Gradients for Readability --}}
            <div class="absolute inset-0 bg-gradient-to-r from-[#0b0b0b] via-[#0b0b0b]/40 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#0b0b0b] via-transparent to-transparent"></div>

            <div class="absolute bottom-16 left-12 max-w-2xl">
                <span class="bg-[#E21B22] text-white px-4 py-1 rounded-full text-[10px] font-black uppercase mb-4 inline-block tracking-widest">Now Featured</span>
                <h1 class="text-7xl font-black uppercase tracking-tighter mb-4 italic text-white leading-none">
                    {{ $featured->title }}
                </h1>
                
                <div class="flex items-center gap-4 text-sm text-gray-300 mb-6 font-bold uppercase tracking-widest">
                    <span class="border border-gray-500 px-2 py-0.5 rounded text-xs">{{ $featured->rating }}</span>
                    <span>{{ $featured->runtime_minutes }} min</span>
                    <span>•</span>
                    <span>{{ \Carbon\Carbon::parse($featured->release_date)->year }}</span>
                </div>

                <p class="text-gray-400 text-lg mb-8 leading-relaxed line-clamp-3">
                    {{ $featured->synopsis }}
                </p>

                <div class="flex gap-4">
                    <a href="{{ route('movies.show', $featured->movie_id) }}" class="bg-[#E21B22] hover:bg-red-700 px-10 py-4 rounded-xl font-black uppercase text-sm transition-all transform hover:scale-105 shadow-lg shadow-red-600/20">
                        Book Now
                    </a>
                    <button class="bg-white/10 hover:bg-white/20 backdrop-blur-md px-10 py-4 rounded-xl font-black uppercase text-sm transition-all border border-white/10">
                        More Info
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Now Showing Section --}}
    <div class="mb-20">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-4xl font-black uppercase tracking-tighter italic">Now <span class="text-red-600">Showing</span></h2>
            <div class="h-px flex-grow bg-zinc-800 ml-8"></div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            @foreach($nowShowing as $movie)
                <div class="group cursor-pointer">
                    <div class="relative aspect-[2/3] overflow-hidden rounded-2xl mb-4 shadow-xl ring-1 ring-white/5">
                        <img src="{{ asset('posters/' . $movie->poster_url) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="{{ $movie->title }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                        
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/40 backdrop-blur-sm">
                             <a href="{{ route('movies.show', $movie->movie_id) }}" class="bg-[#E21B22] text-white p-4 rounded-full shadow-2xl transform translate-y-4 group-hover:translate-y-0 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                </svg>
                             </a>
                        </div>
                    </div>
                    <h3 class="text-xl font-black uppercase italic tracking-tighter mb-1 text-white truncate">{{ $movie->title }}</h3>
                    <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-4">{{ $movie->genre }} • {{ $movie->runtime_minutes }} min</p>
                    <a href="{{ route('movies.show', $movie->movie_id) }}" class="block w-full bg-[#E21B22] hover:bg-red-700 py-3 rounded-lg text-center text-xs font-black uppercase tracking-widest transition-colors shadow-lg shadow-red-900/20">
                        Book Now
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Coming Soon Section --}}
    <div class="mb-20">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-4xl font-black uppercase tracking-tighter italic text-zinc-500">Coming <span class="text-zinc-700">Soon</span></h2>
            <div class="h-px flex-grow bg-zinc-900 ml-8"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            @foreach($comingSoon as $movie)
                <div class="group opacity-80 hover:opacity-100 transition-opacity">
                    <div class="relative aspect-[2/3] overflow-hidden rounded-2xl mb-4 grayscale hover:grayscale-0 transition-all duration-500 ring-1 ring-white/5">
                        <img src="{{ asset('posters/' . $movie->poster_url) }}" class="w-full h-full object-cover" alt="{{ $movie->title }}">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <h3 class="text-xl font-black uppercase italic tracking-tighter mb-1 text-zinc-400 truncate">{{ $movie->title }}</h3>
                    <p class="text-xs font-bold text-zinc-600 uppercase tracking-widest mb-4">{{ $movie->genre }} • {{ $movie->runtime_minutes }} min</p>
                    <button disabled class="w-full bg-zinc-800 text-zinc-500 py-3 rounded-lg text-xs font-black uppercase tracking-widest cursor-not-allowed">
                        Coming Soon
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection