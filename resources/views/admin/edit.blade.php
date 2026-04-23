@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-black py-12 px-4">
    
    <div class="max-w-3xl mx-auto bg-[#0e0f12] border border-zinc-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
        
        {{-- Header --}}
        <div class="flex justify-between items-center p-8 border-b border-zinc-800">
            <h1 class="text-3xl font-black uppercase tracking-tighter text-white">Edit Movie</h1>
            <a href="{{ route('movies.index') }}" class="p-2 bg-zinc-800 rounded-full text-zinc-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
        </div>

        <form action="{{ route('movies.update', $movie->movie_id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            {{-- Poster Upload Section --}}
            <div class="space-y-4">
                <label class="block text-sm font-bold text-zinc-400 uppercase tracking-widest">Movie Poster <span class="text-red-500">*</span></label>
                <div class="relative group">
                    <input type="file" name="poster" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    {{-- CHANGED: Updated input background to bg-[#09090b] and border to zinc-800 for that cleaner, slightly darker input box look --}}
                    <div class="border-2 border-dashed border-zinc-800 rounded-3xl p-12 flex flex-col items-center justify-center bg-[#09090b] group-hover:border-red-600/50 transition">
                        <svg class="w-12 h-12 text-zinc-600 mb-4 group-hover:text-red-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <p class="text-white font-bold">Click to upload poster</p>
                        <p class="text-zinc-500 text-sm mt-1">PNG, JPG up to 10MB</p>
                    </div>
                </div>
                @if($movie->poster_url)
                    <p class="text-xs text-zinc-500">Current: <span class="text-red-500">{{ $movie->poster_url }}</span></p>
                @endif
            </div>

            {{-- Title --}}
            <div class="space-y-2">
                <label class="block text-sm font-bold text-zinc-400 uppercase tracking-widest">Movie Title <span class="text-red-500">*</span></label>
                {{-- CHANGED: Input fields background updated from zinc-950 to bg-[#09090b] for a smoother transition to the new container color --}}
                <input type="text" name="title" value="{{ old('title', $movie->title) }}" class="w-full bg-[#09090b] border border-zinc-800 rounded-2xl p-4 text-white focus:border-red-600 outline-none transition" required>
            </div>

            {{-- Genre --}}
            <div class="space-y-2">
                <label class="block text-sm font-bold text-zinc-400 uppercase tracking-widest">Genre <span class="text-red-500">*</span></label>
                <input type="text" name="genre" value="{{ old('genre', $movie->genre) }}" class="w-full bg-[#09090b] border border-zinc-800 rounded-2xl p-4 text-white focus:border-red-600 outline-none transition" required>
            </div>

            <div class="grid grid-cols-2 gap-6">
                {{-- Duration --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-zinc-400 uppercase tracking-widest">Duration <span class="text-red-500">*</span></label>
                    <input type="number" name="runtime_minutes" value="{{ old('runtime_minutes', $movie->runtime_minutes) }}" placeholder="Minutes (e.g. 120)" class="w-full bg-[#09090b] border border-zinc-800 rounded-2xl p-4 text-white focus:border-red-600 outline-none transition" required>
                </div>

                {{-- Rating --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-zinc-400 uppercase tracking-widest">Rating <span class="text-red-500">*</span></label>
                    <select name="rating" class="w-full bg-[#09090b] border border-zinc-800 rounded-2xl p-4 text-white focus:border-red-600 outline-none transition appearance-none" required>
                        <option value="G" {{ $movie->rating == 'G' ? 'selected' : '' }}>G</option>
                        <option value="PG" {{ $movie->rating == 'PG' ? 'selected' : '' }}>PG</option>
                        <option value="PG-13" {{ $movie->rating == 'PG-13' ? 'selected' : '' }}>PG-13</option>
                        <option value="R" {{ $movie->rating == 'R' ? 'selected' : '' }}>R</option>
                    </select>
                </div>
            </div>

            {{-- Year --}}
            <div class="space-y-2">
                <label class="block text-sm font-bold text-zinc-400 uppercase tracking-widest">Release Date <span class="text-red-500">*</span></label>
                <input type="date" name="release_date" value="{{ old('release_date', $movie->release_date) }}" class="w-full bg-[#09090b] border border-zinc-800 rounded-2xl p-4 text-white focus:border-red-600 outline-none transition" required>
            </div>

            {{-- Synopsis --}}
            <div class="space-y-2">
                <label class="block text-sm font-bold text-zinc-400 uppercase tracking-widest">Synopsis <span class="text-red-500">*</span></label>
                <textarea name="synopsis" rows="4" class="w-full bg-[#09090b] border border-zinc-800 rounded-2xl p-4 text-white focus:border-red-600 outline-none transition" placeholder="Enter movie synopsis...">{{ old('synopsis', $movie->synopsis) }}</textarea>
            </div>

            {{-- Category / Status --}}
            <div class="space-y-4">
                <label class="block text-sm font-bold text-zinc-400 uppercase tracking-widest">Category <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer group">
                        <input type="radio" name="showing_status" value="Now Showing" class="hidden peer" {{ $movie->showing_status == 'Now Showing' ? 'checked' : '' }}>
                        <div class="flex items-center justify-between p-4 bg-[#09090b] border border-zinc-800 rounded-2xl peer-checked:border-red-600 peer-checked:bg-red-600/5 transition">
                            <span class="text-zinc-400 peer-checked:text-white font-bold">Now Showing</span>
                            <div class="w-5 h-5 rounded-full border-2 border-zinc-700 flex items-center justify-center peer-checked:border-red-600">
                                <div class="w-2.5 h-2.5 rounded-full bg-red-600 opacity-0 peer-checked:opacity-100 transition"></div>
                            </div>
                        </div>
                    </label>

                    <label class="cursor-pointer group">
                        <input type="radio" name="showing_status" value="Coming Soon" class="hidden peer" {{ $movie->showing_status == 'Coming Soon' ? 'checked' : '' }}>
                        <div class="flex items-center justify-between p-4 bg-[#09090b] border border-zinc-800 rounded-2xl peer-checked:border-red-600 peer-checked:bg-red-600/5 transition">
                            <span class="text-zinc-400 peer-checked:text-white font-bold">Coming Soon</span>
                            <div class="w-5 h-5 rounded-full border-2 border-zinc-700 flex items-center justify-center peer-checked:border-red-600">
                                <div class="w-2.5 h-2.5 rounded-full bg-red-600 opacity-0 peer-checked:opacity-100 transition"></div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="flex gap-4 pt-8">
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-black uppercase tracking-widest py-5 rounded-2xl transition shadow-[0_0_20px_rgba(220,38,38,0.3)]">
                    Save Changes
                </button>
                <a href="{{ route('movies.index') }}" class="px-10 bg-[#09090b] border border-zinc-800 hover:bg-zinc-800 text-white font-black uppercase tracking-widest py-5 rounded-2xl transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection