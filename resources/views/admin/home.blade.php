@extends('layouts.app')

@section('content')
    <div class="py-12 bg-black min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="mb-12">
                <h1 class="text-4xl font-bold tracking-tight uppercase">Welcome to Cinema Z</h1>
                <p class="mt-4 text-gray-400 text-lg">
                    Your premier destination for cinema management. Use the navigation below to manage movies, showtimes, and tickets.
                </p>
            </div>

            {{-- Live Statistics Section --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-12">
    
    <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl">
        <p class="text-red-600 text-[10px] font-black uppercase tracking-widest mb-1">Now Showing</p>
        <div class="flex items-end justify-between">
            <h3 class="text-3xl font-bold text-red-500">{{ $stats->active_movies ?? 0 }}</h3>
            <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse mb-2"></div>
        </div>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl">
        <p class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-1">Weekly Schedules</p>
        <div class="flex items-end justify-between">
            <h3 class="text-3xl font-bold">{{ $stats->showtimes_this_week ?? 0 }}</h3>
            <span class="text-zinc-700 text-xs italic">Upcoming</span>
        </div>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl">
        <p class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-1">Tickets Sold</p>
        <div class="flex items-end justify-between">
            <h3 class="text-3xl font-bold text-white">{{ $stats->tickets_sold_last_7_days ?? 0 }}</h3>
            <span class="text-zinc-700 text-xs italic">Last 7 Days</span>
        </div>
    </div>
</div>

            {{-- Navigation Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.add_movies') }}" class="block p-8 bg-zinc-900 border border-zinc-800 rounded-2xl hover:bg-zinc-800 transition-all group">
                    <div class="mb-4">
                        <span class="text-3xl group-hover:scale-110 transition-transform inline-block">🎬</span>
                    </div>
                    <h2 class="text-xl font-bold uppercase tracking-tight">Add Movies</h2>
                    <p class="text-gray-500 mt-2 text-sm leading-relaxed">Expand your collection with the latest blockbusters.</p>
                </a>

                <a href="{{ route('movies.index') }}" class="block p-8 bg-zinc-900 border border-zinc-800 rounded-2xl hover:bg-zinc-800 transition-all group">
                    <div class="mb-4">
                        <span class="text-3xl group-hover:scale-110 transition-transform inline-block">🕒</span>
                    </div>
                    <h2 class="text-xl font-bold uppercase tracking-tight">Manage Catalog</h2>
                    <p class="text-gray-500 mt-2 text-sm leading-relaxed">Update showing status, edit details, or remove titles.</p>
                </a>

                <a href="{{ route('schedules.index') }}" class="block p-8 bg-zinc-900 border border-zinc-800 rounded-2xl hover:bg-zinc-800 transition-all group">
                    <div class="mb-4">
                        <span class="text-3xl group-hover:scale-110 transition-transform inline-block">🎟️</span>
                    </div>
                    <h2 class="text-xl font-bold uppercase tracking-tight">Showtimes</h2>
                    <p class="text-gray-500 mt-2 text-sm leading-relaxed">Set up movie schedules and manage theater availability.</p>
                </a>
            </div>
        </div>
    </div>
@endsection