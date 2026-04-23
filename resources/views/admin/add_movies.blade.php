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
            <p class="mt-2 text-gray-400 max-w-2xl">Fill in the details below to add a new movie to the Cinema Z catalog. All fields marked with an asterisk (<span class="text-red-500">*</span>) are required.</p>
        </div>

        <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-[1fr,1.5fr] gap-8">
                
                {{-- LEFT COLUMN CONTENTS NI DIRI--}}
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

                {{-- RIGHT COLUMN CONTENTS NI DIRI --}}
                <div class="space-y-6 p-8 bg-zinc-900 border border-zinc-800 rounded-3xl">
                    <h2 class="text-xl font-bold uppercase tracking-tight mb-6">Movie Details</h2>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Movie Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" placeholder="Enter the movie title" class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-red-600 focus:ring-0" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Genre <span class="text-red-500">*</span></label>
                            <input type="text" name="genre" placeholder="e.g., Action, Sci-Fi" class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-red-600 focus:ring-0" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Rating <span class="text-red-500">*</span></label>
                            <select name="rating" class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white focus:border-red-600 focus:ring-0" required>
                                <option value="G">G</option>
                                <option value="PG">PG</option>
                                <option value="PG-13">PG-13</option>
                                <option value="R">R</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Duration (Mins) <span class="text-red-500">*</span></label>
                            <input type="number" name="runtime_minutes" placeholder="120" class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-red-600 focus:ring-0" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Release Date <span class="text-red-500">*</span></label>
                            <input type="date" name="release_date" class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white focus:border-red-600 focus:ring-0" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Synopsis <span class="text-red-500">*</span></label>
                        <textarea name="synopsis" rows="4" placeholder="Write a compelling description..." class="w-full bg-black border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-red-600 focus:ring-0" required></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Screening Category <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="showing_status" value="Now Showing" class="hidden peer" checked>
                                <div class="p-4 border border-zinc-700 rounded-xl text-center peer-checked:border-red-600 peer-checked:bg-red-600/10 transition">
                                    <span class="block font-bold">Now Showing</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="showing_status" value="Coming Soon" class="hidden peer">
                                <div class="p-4 border border-zinc-700 rounded-xl text-center peer-checked:border-red-600 peer-checked:bg-red-600/10 transition">
                                    <span class="block font-bold">Coming Soon</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8 pt-8 border-t border-zinc-800">
                        <a href="{{ route('admin.home') }}" class="px-8 py-3 bg-zinc-800 hover:bg-zinc-700 text-white rounded-xl font-bold transition">Cancel</a>
                        <button type="submit" class="px-12 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-extrabold uppercase tracking-widest transition">Add Movie</button>
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