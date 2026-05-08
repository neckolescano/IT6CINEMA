<div onclick="toggleSeat(this, '{{ $row }}{{ $col }}')" 
     data-seat-id="{{ $row }}{{ $col }}"
     class="seat-item w-8 h-10 border-2 border-red-600/30 rounded-t-xl rounded-b-md cursor-pointer transition-all hover:bg-red-600/20 flex items-center justify-center text-[10px] text-zinc-700 hover:text-white font-bold">
     {{ $col }}
</div>