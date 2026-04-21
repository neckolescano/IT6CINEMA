@extends('layouts.app')

@section('content')
    <div class="py-12 bg-black min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-12">
                <h1 class="text-4xl font-bold tracking-tight uppercase">Welcome to Cinema Z</h1>
                <p class="mt-4 text-gray-400 text-lg">
                    Your premier destination for cinema management. Use the navigation above to manage movies, showtimes, and tickets.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Fixed Route Link --}}
                <a href="{{ route('admin.add_movies') }}" class="block p-8 bg-zinc-900 border border-zinc-800 rounded-2xl hover:bg-zinc-800 transition-all group">
                    <div class="mb-4">
                        <span class="text-3xl group-hover:scale-110 transition-transform inline-block">🎬</span>
                    </div>
                    <h2 class="text-xl font-bold uppercase">Add Movies</h2>
                    <p class="text-gray-500 mt-2">Add new movies to your catalog</p>
                </a>

                <a href="#" class="block p-8 bg-zinc-900 border border-zinc-800 rounded-2xl hover:bg-zinc-800 transition-all group">
                    <div class="mb-4">
                        <span class="text-3xl group-hover:scale-110 transition-transform inline-block">🕒</span>
                    </div>
                    <h2 class="text-xl font-bold uppercase">Showtimes</h2>
                    <p class="text-gray-500 mt-2">Manage screening schedules</p>
                </a>

                <a href="#" class="block p-8 bg-zinc-900 border border-zinc-800 rounded-2xl hover:bg-zinc-800 transition-all group">
                    <div class="mb-4">
                        <span class="text-3xl group-hover:scale-110 transition-transform inline-block">🎟️</span>
                    </div>
                    <h2 class="text-xl font-bold uppercase">Tickets</h2>
                    <p class="text-gray-500 mt-2">View and manage ticket sales</p>
                </a>

            </div>
        </div>
    </div>
@endsection