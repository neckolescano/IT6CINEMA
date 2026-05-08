@extends('layouts.app')

@section('content')
<div class="py-12 bg-black min-h-screen text-white">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-950/50 border border-red-900 rounded-full text-red-500 text-xs font-bold uppercase tracking-widest mb-3">
                <span>🛡️</span> ADMIN PANEL
            </div>
            <h1 class="text-5xl font-extrabold uppercase tracking-tighter">ADD NEW MOVIE</h1>
            <p class="mt-2 text-gray-400 max-w-2xl">Fill in the details below to add a new movie to the catalog. It will automatically appear in "Coming Soon" until a schedule is assigned.</p>
        </div>

        <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-[1fr,1.5fr] gap-8">
                
                {{-- LEFT COLUMN: Poster Upload --}}
                <div class="space-y-6">
                    <div class="p-8 bg-zinc-900 border border-zinc-800 rounded-3xl">
                        <h2 class="text-xl font-bold uppercase tracking-tight mb-6">Movie Poster</h2>
                        
                        <div class="relative aspect-[2/3] w-full bg-black border-2 border-dashed border-zinc-700 rounded-2xl flex flex-col items-center justify-center text-center p-6 group hover:border-red-600 transition">
                            <input type="file" name="poster" id="poster" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                            <span class="text-5xl mb-4 text-zinc-600 group-hover:scale-110 group-hover:text-white transition">➕</span>
                            <p class="text-white font-bold">Click to upload</p>
                            <p class="text-sm text-gray-500 mt-1">or drag and drop</p>
                            <p class="text-[10px] uppercase text-zinc-600 bg-zinc-800 px-2 py-1 rounded mt-4">Recommended 2:3 ratio • Max 5MB</p>
                            <img id="poster-preview" class="absolute inset-0 w-full h-full object-cover rounded-2xl hidden z-0">
                        </div>
                        <x-input-error :messages="$errors->get('poster')" class="mt-2" />
                    </div>

                    <div class="p-6 bg-yellow-950/20 border border-yellow-900/50 rounded-2xl text-sm flex gap-4 text-yellow-400">
                        <span>💡</span>
                        <p><strong class="text-white">Quick Tip:</strong> High-quality posters improve engagement.</p>
                    </div>
                </div>

                {{-- RIGHT COLUMN: Movie Details --}}
                <div class="space-y-6 p-8 bg-zinc-900 border border-zinc-800 rounded-3xl">
                    <h2 class="text-xl font-bold uppercase tracking-tight mb-6">Movie Details</h2>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Movie Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter the movie title" class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-red-600 focus:ring-0" required>
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Genre <span class="text-red-500">*</span></label>
                            <input type="text" name="genre" value="{{ old('genre') }}" placeholder="e.g., Action, Sci-Fi" class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-red-600 focus:ring-0" required>
                            <x-input-error :messages="$errors->get('genre')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Rating <span class="text-red-500">*</span></label>
                            <select name="rating" class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white focus:border-red-600 focus:ring-0" required>
                                <option value="G" {{ old('rating') == 'G' ? 'selected' : '' }}>G</option>
                                <option value="PG" {{ old('rating') == 'PG' ? 'selected' : '' }}>PG</option>
                                <option value="PG-13" {{ old('rating') == 'PG-13' ? 'selected' : '' }}>PG-13</option>
                                <option value="R" {{ old('rating') == 'R' ? 'selected' : '' }}>R</option>
                                <option value="R-18" {{ old('rating') == 'R-18' ? 'selected' : '' }}>R-18</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                       <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Duration (Mins) <span class="text-red-500">*</span></label>
                            <input type="number" name="runtime_minutes" value="{{ old('runtime_minutes') }}" placeholder="120" class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-red-600 focus:ring-0" required>
                            <x-input-error :messages="$errors->get('runtime_minutes')" class="mt-1" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Release Date <span class="text-red-500">*</span></label>
                            <input type="date" name="release_date" value="{{ old('release_date') }}" class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white focus:border-red-600 focus:ring-0" required>
                            <x-input-error :messages="$errors->get('release_date')" class="mt-1" />
                        </div>
                    </div>

                    {{-- Showing Status - Visual only, defaults to Coming Soon --}}
                    <div class="mt-6">
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Initial Status</label>
                        <div class="grid grid-cols-3 gap-2 p-1 bg-black border border-zinc-700 rounded-xl">
                            {{-- Hidden input ensures the value 'Coming Soon' is actually sent to the server --}}
                            <input type="hidden" name="showing_status" value="Coming Soon">
                            
                            <div class="py-2 text-center rounded-lg bg-red-600 text-white text-xs font-bold uppercase tracking-wider shadow-lg">
                                Coming Soon
                            </div>
                            <div class="py-2 text-center rounded-lg text-zinc-600 text-xs font-bold uppercase tracking-wider cursor-not-allowed border border-transparent">
                                Now Showing
                            </div>
                            <div class="py-2 text-center rounded-lg text-zinc-600 text-xs font-bold uppercase tracking-wider cursor-not-allowed border border-transparent">
                                Ended
                            </div>
                        </div>
                        <p class="text-[10px] text-zinc-500 mt-2 italic px-1">
                            * Status is locked to "Coming Soon." It will automatically update to "Now Showing" once you assign it to a cinema schedule.
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Synopsis <span class="text-red-500">*</span></label>
                        <textarea name="synopsis" rows="5" placeholder="Write a compelling description..." class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-red-600 focus:ring-0" required>{{ old('synopsis') }}</textarea>
                        <x-input-error :messages="$errors->get('synopsis')" class="mt-1" />
                    </div>  

                    <div class="flex justify-end gap-4 mt-8 pt-8 border-t border-zinc-800">
                        <a href="{{ route('movies.index') }}" class="px-8 py-3 bg-zinc-800 hover:bg-zinc-700 text-white rounded-xl font-bold transition">Cancel</a>
                        <button type="submit" class="px-12 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-extrabold uppercase tracking-widest transition shadow-lg shadow-red-600/20">Add Movie</button>
                    </div>
                </div> 

            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('poster').onchange = evt => {
        const [file] = evt.target.files
        if (file) {
            document.getElementById('poster-preview').src = URL.createObjectURL(file);
            document.getElementById('poster-preview').classList.remove('hidden');
        }
    }
</script>
@endsection