<div class="bg-zinc-900/50 border border-zinc-800 rounded-[2rem] overflow-hidden group">

    {{-- Poster naa diri --}}
    <div class="relative aspect-[3/4] overflow-hidden">
        <img src="{{ asset('images/' . $movie->poster_url) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
        
        {{-- Status Badge ni sya --}}
        <div class="absolute top-4 left-4">
            <span class="bg-red-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">
                {{ $movie->showing_status }}
            </span>
        </div>

        {{-- Admin Action Buttons naa diri --}}

        <div class="absolute top-4 right-4 flex flex-col gap-2">
            <a href="{{ route('movies.edit', $movie->movie_id) }}" class="p-3 bg-black/60 backdrop-blur-md border border-white/10 rounded-full text-white hover:bg-white hover:text-black transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
            </a>
            <form action="{{ route('movies.destroy', $movie->movie_id) }}" method="POST" onsubmit="return confirm('Delete this movie?')">
                @csrf @method('DELETE')
                <button class="p-3 bg-black/60 backdrop-blur-md border border-white/10 rounded-full text-white hover:bg-red-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            </form>
        </div>
    </div>

        {{-- Movie Info sad ni--}}
        
        <div class="p-6">
            <h3 class="text-xl font-bold truncate mb-1">{{ $movie->title }}</h3>
            <p class="text-xs text-zinc-500 font-medium mb-4">{{ $movie->genre }} • {{ $movie->runtime_minutes }}m</p>
            
            <div class="flex items-center justify-between pt-4 border-t border-zinc-800">
                <span class="px-3 py-1 bg-zinc-800 rounded text-[10px] font-bold text-zinc-400 border border-zinc-700">
                    {{ $movie->rating }}
                </span>
                <span class="text-xs font-bold text-zinc-500 uppercase tracking-widest">
                    {{ \Carbon\Carbon::parse($movie->release_date)->year }}
                </span>
            </div>
        </div>
</div>