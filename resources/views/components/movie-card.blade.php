@props(['movie', 'type'])

<div class="group cursor-pointer">
    <div class="relative aspect-[2/3] overflow-hidden rounded-3xl mb-4 border border-white/5 shadow-2xl">
        <img src="{{ $movie->poster_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $movie->title }}">
        
        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
            <span class="text-xs font-bold uppercase tracking-widest bg-white/10 backdrop-blur-md px-4 py-2 rounded-full">View Details</span>
        </div>
    </div>

    <h3 class="text-lg font-bold truncate">{{ $movie->title }}</h3>
    <p class="text-xs text-gray-500 font-medium mb-4">{{ $movie->genre }} • {{ $movie->runtime_minutes }}min</p>

    @if($type == 'now-showing')
        <a href="{{ route('movies.show', $movie->movie_id) }}" 
           class="block w-full bg-[#E21B22] hover:bg-red-700 text-center py-3 rounded-xl text-xs font-black uppercase tracking-widest transition">
           Book Now
        </a>
    @else
        <button disabled class="w-full bg-[#2a2a2a] text-gray-500 py-3 rounded-xl text-xs font-black uppercase tracking-widest cursor-not-allowed">
           Coming Soon
        </button>
    @endif
</div>