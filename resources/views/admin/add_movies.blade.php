@extends('layouts.app') {{-- This pulls in your main layout --}}

@section('content') {{-- This injects the form into the @yield('content') in your layout --}}
<div class="py-12 bg-black min-h-screen text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10">
            <nav class="flex text-zinc-500 text-sm mb-4 uppercase tracking-widest font-bold">
                <a href="{{ route('dashboard') }}" class="hover:text-white transition">Admin</a>
                <span class="mx-2">/</span>
                <span class="text-zinc-200">Add New Movie</span>
            </nav>
            <h1 class="text-4xl font-extrabold tracking-tighter uppercase">Add New Movie</h1>
        </div>

        <form action="{{ route('movies.store') }}" method="POST" class="bg-zinc-900/50 border border-zinc-800 p-10 rounded-3xl shadow-2xl">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Movie Title</label>
                    <input type="text" name="title" required placeholder="e.g. Inception"
                        class="w-full bg-black border-zinc-800 rounded-xl py-4 px-5 text-white focus:border-red-600 focus:ring-red-600 transition outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Genre</label>
                    <input type="text" name="genre" required placeholder="Action, Sci-Fi"
                        class="w-full bg-black border-zinc-800 rounded-xl py-4 px-5 text-white focus:border-red-600 focus:ring-red-600 transition outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Rating</label>
                    <select name="rating" required 
                        class="w-full bg-black border-zinc-800 rounded-xl py-4 px-5 text-white focus:border-red-600 focus:ring-red-600 transition outline-none">
                        <option value="G">G</option>
                        <option value="PG">PG</option>
                        <option value="PG-13">PG-13</option>
                        <option value="R">R</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Runtime (Mins)</label>
                    <input type="number" name="runtime_minutes" required placeholder="120"
                        class="w-full bg-black border-zinc-800 rounded-xl py-4 px-5 text-white focus:border-red-600 focus:ring-red-600 transition outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Showing Status</label>
                    <select name="showing_status" required 
                        class="w-full bg-black border-zinc-800 rounded-xl py-4 px-5 text-white focus:border-red-600 focus:ring-red-600 transition outline-none">
                        <option value="Now Showing">Now Showing</option>
                        <option value="Coming Soon">Coming Soon</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                     <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Release Date</label>
                     <input type="date" name="release_date" required
                        class="w-full bg-black border-zinc-800 rounded-xl py-4 px-5 text-white focus:border-red-600 focus:ring-red-600 transition outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Synopsis</label>
                    <textarea name="synopsis" rows="4" placeholder="Brief description..."
                        class="w-full bg-black border-zinc-800 rounded-xl py-4 px-5 text-white focus:border-red-600 focus:ring-red-600 transition outline-none"></textarea>
                </div>
            </div>

            <div class="mt-10 flex justify-end">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-12 rounded-xl transition-all duration-300 uppercase tracking-widest shadow-lg shadow-red-600/20">
                    Confirm & Save Movie
                </button>
            </div>
        </form>
    </div>
</div>
@endsection