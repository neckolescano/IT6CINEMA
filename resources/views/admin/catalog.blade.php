@extends('layouts.app')

@section('content')
<div class="py-12 bg-black min-h-screen text-white" 
     x-data="{ 
        tab: 'now_showing', 
        search: '',
        matchesSearch(title, genre) {
            let q = this.search.toLowerCase();
            return title.toLowerCase().includes(q) || genre.toLowerCase().includes(q);
        }
     }"> 
        
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section ni diri--}}
        <div class="flex justify-between items-end mb-12">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-950/50 border border-red-900 rounded-full text-red-500 text-[10px] font-bold uppercase tracking-widest mb-4">
                    <span>🎬</span> MOVIE MANAGEMENT
                </div>
                <h1 class="text-6xl font-black uppercase tracking-tighter">MANAGE MOVIES</h1>
                <p class="mt-2 text-gray-400 max-w-xl">View, edit, and manage all movies in your Cinema Z catalog.</p>
            </div>
            
            <a href="{{ route('admin.add_movies') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest transition transform hover:scale-105">
                <span class="text-xl">+</span> ADD NEW MOVIE
            </a>
        </div>

        {{-- Search Bar pud ni--}}
        <div class="relative max-w-xl mb-10">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input 
                type="text" 
                x-model="search" 
                placeholder="Search movies by title or genre..." 
                class="w-full bg-[#0e0f12] border border-zinc-800 rounded-2xl py-4 pl-12 pr-4 text-white placeholder-zinc-500 focus:border-red-600 outline-none transition shadow-2xl"
            >
        </div>

        {{-- Filter Tabs ang ga store ani--}}
        <div class="flex gap-4 mb-10">
            <button @click="tab = 'all'" :class="tab === 'all' ? 'bg-red-600 text-white' : 'bg-zinc-900 text-gray-400 border border-zinc-800'" class="px-6 py-3 rounded-xl font-bold transition">
                All Movies ({{ $allMovies->count() }})
            </button>
            <button @click="tab = 'now_showing'" :class="tab === 'now_showing' ? 'bg-red-600 text-white' : 'bg-zinc-900 text-gray-400 border border-zinc-800'" class="px-6 py-3 rounded-xl font-bold transition">
                Now Showing ({{ $nowShowing->count() }})
            </button>
            <button @click="tab = 'coming_soon'" :class="tab === 'coming_soon' ? 'bg-red-600 text-white' : 'bg-zinc-900 text-gray-400 border border-zinc-800'" class="px-6 py-3 rounded-xl font-bold transition">
                Coming Soon ({{ $comingSoon->count() }})
            </button>
            <button @click="tab = 'ended'" :class="tab === 'ended' ? 'bg-red-600 text-white' : 'bg-zinc-900 text-gray-400 border border-zinc-800'" class="px-6 py-3 rounded-xl font-bold transition">
                Ended ({{ $ended->count() }})
            </button>
        </div>

        {{-- Movie Grid Containers --}}
        {{-- 1. All Movies Tab --}}
        <template x-if="tab === 'all'">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($allMovies as $movie)
                    <div x-show="matchesSearch('{{ $movie->title }}', '{{ $movie->genre }}')">
                        @include('admin.partials.movie_management_card', ['movie' => $movie])
                    </div>
                @endforeach
            </div>
        </template>

        {{-- 2. Now Showing Tab --}}
        <template x-if="tab === 'now_showing'">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($nowShowing as $movie)
                    <div x-show="matchesSearch('{{ $movie->title }}', '{{ $movie->genre }}')">
                        @include('admin.partials.movie_management_card', ['movie' => $movie])
                    </div>
                @endforeach
            </div>
        </template>

        {{-- 3. Coming Soon Tab --}}
        <template x-if="tab === 'coming_soon'">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($comingSoon as $movie)
                    <div x-show="matchesSearch('{{ $movie->title }}', '{{ $movie->genre }}')">
                        @include('admin.partials.movie_management_card', ['movie' => $movie])
                    </div>
                @endforeach
            </div>
        </template>

        {{-- 4. Ended Tab --}}
        <template x-if="tab === 'ended'">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($ended as $movie)
                    <div x-show="matchesSearch('{{ $movie->title }}', '{{ $movie->genre }}')">
                        @include('admin.partials.movie_management_card', ['movie' => $movie])
                    </div>
                @endforeach
            </div>
        </template>
    </div>
</div>
@endsection