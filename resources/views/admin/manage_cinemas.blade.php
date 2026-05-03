@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0a0a0a] text-white p-8 font-sans">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex justify-between items-end mb-12 border-b border-gray-800 pb-6">
            <div>
                <h1 class="text-4xl font-black tracking-tighter text-white uppercase italic">
                    <span class="text-red-600">Manage</span> Infrastructure
                </h1>
                <p class="text-gray-500 text-sm mt-2 tracking-widest uppercase">CinemaZ Theater Configuration</p>
            </div>
            <div class="text-right hidden md:block">
                <p class="text-[10px] text-red-500 font-bold tracking-[0.4em] uppercase mb-1">System Status</p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-xs font-mono">ALL SYSTEMS NOMINAL</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-10">
            
            <!-- Side Panel: Configuration -->
            <div class="xl:col-span-1">
                <div class="bg-[#141414] rounded-2xl p-6 border border-white/5 shadow-2xl sticky top-8">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-2 h-6 bg-red-600 rounded-full"></div>
                        <h2 class="text-lg font-bold tracking-tight uppercase text-red-500">New Auditorium</h2>
                    </div>
                    
                    <form action="{{ route('cinemas.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 mb-2 uppercase tracking-widest">Auditorium Name</label>
                            <input type="text" name="cinema_name" required placeholder="IMAX 01"
                                   class="w-full bg-[#1e1e1e] border border-gray-800 rounded-xl p-4 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-all placeholder:text-gray-700">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 mb-2 uppercase tracking-widest">Total Rows</label>
                                <input type="number" name="num_rows" min="1" max="26" value="8" required
                                       class="w-full bg-[#1e1e1e] border border-gray-800 rounded-xl p-4 text-white focus:border-red-600 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 mb-2 uppercase tracking-widest">Seats/Row</label>
                                <input type="number" name="seats_per_row" min="1" max="30" value="12" required
                                       class="w-full bg-[#1e1e1e] border border-gray-800 rounded-xl p-4 text-white focus:border-red-600 outline-none transition-all">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl mt-4 transition-all uppercase tracking-widest shadow-[0_10px_20px_rgba(220,38,38,0.2)] active:scale-95 flex items-center justify-center gap-2 group">
                            <span>Initialize Room</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-90 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Display -->
            <div class="xl:col-span-3 space-y-12">
                @if($cinemas->isEmpty())
                    <div class="bg-[#111] border-2 border-dashed border-gray-900 rounded-3xl p-32 text-center">
                        <div class="bg-gray-900/50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7" />
                            </svg>
                        </div>
                        <p class="text-gray-600 font-medium italic">No auditoriums have been initialized in the system.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-12">
                        @foreach($cinemas as $cinema)
                        <div class="bg-[#111] rounded-3xl border border-gray-800/50 overflow-hidden shadow-2xl relative group">
                            
                            <!-- Action Toolbar (FIXED PARAMETERS) -->
                            <div class="absolute top-6 right-6 flex items-center gap-3 z-10">
                                <a href="{{ route('cinemas.edit', ['cinema' => $cinema->cinema_id]) }}" class="p-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg transition-all group/edit" title="Edit Configuration">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover/edit:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('cinemas.destroy', ['cinema' => $cinema->cinema_id]) }}" method="POST" 
                                      onsubmit="return confirm('CRITICAL: This will permanently dismantle this auditorium and all associated seat data. Proceed?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-600/10 hover:bg-red-600 border border-red-600/20 rounded-lg transition-all group/del">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 group-hover/del:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>

                                <div class="h-8 w-[1px] bg-gray-800 mx-1"></div>
                                <span class="bg-red-600/10 text-red-500 text-[10px] font-black px-3 py-1 rounded-full border border-red-600/20 uppercase tracking-widest">Operational</span>
                            </div>

                            <!-- Cinema Content -->
                            <div class="p-8 border-b border-gray-800/50 bg-gradient-to-r from-[#161616] to-transparent">
                                <h3 class="font-black text-2xl text-white uppercase italic tracking-tighter">{{ $cinema->cinema_name }}</h3>
                                <div class="flex items-center gap-4 mt-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-sm bg-red-600/30 border border-red-600/50"></div>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">{{ $cinema->capacity }} Total Units</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-12 bg-black/40">
                                <div class="relative mb-20">
                                    <div class="w-3/4 h-2 bg-gradient-to-r from-transparent via-blue-400/40 to-transparent mx-auto rounded-full blur-sm"></div>
                                    <div class="w-2/3 h-[2px] bg-gradient-to-r from-transparent via-white/20 to-transparent mx-auto -mt-1 shadow-[0_0_15px_rgba(255,255,255,0.3)]"></div>
                                    <p class="text-center text-[9px] text-gray-600 font-black uppercase mt-4 tracking-[0.8em]">Projection Surface</p>
                                </div>
                                
                                <div class="flex flex-col gap-4 items-center overflow-x-auto pb-6">
                                    @php
                                        $groupedSeats = $cinema->seats->sortBy('seat_row')->groupBy('seat_row');
                                    @endphp
                                    
                                    @foreach($groupedSeats as $row => $seats)
                                        <div class="flex gap-4 items-center group/row">
                                            <span class="text-[11px] text-gray-700 font-black w-6 text-right uppercase italic group-hover/row:text-red-500 transition-colors">{{ $row }}</span>
                                            
                                            @php
                                                $rowSeats = $seats->sortBy('seat_number');
                                                $halfPoint = ceil($rowSeats->count() / 2);
                                            @endphp

                                            <div class="flex gap-10 items-center">
                                                <div class="flex gap-2">
                                                    @foreach($rowSeats->take($halfPoint) as $seat)
                                                        <div class="w-6 h-7 rounded-t-lg rounded-b-sm border-2 border-red-600/40 bg-transparent hover:bg-red-600/20 transition-all cursor-pointer relative group/seat shadow-[0_0_10px_rgba(220,38,38,0.05)]" 
                                                             title="Unit {{ $row }}{{ $seat->seat_number }}">
                                                             <div class="absolute bottom-1 left-1 right-1 h-1 bg-red-600/20 rounded-full"></div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="w-6 border-x border-white/5 h-8 flex items-center justify-center">
                                                    <div class="w-[1px] h-full bg-gradient-to-b from-transparent via-gray-800 to-transparent"></div>
                                                </div>

                                                <div class="flex gap-2">
                                                    @foreach($rowSeats->slice($halfPoint) as $seat)
                                                        <div class="w-6 h-7 rounded-t-lg rounded-b-sm border-2 border-red-600/40 bg-transparent hover:bg-red-600/20 transition-all cursor-pointer relative group/seat shadow-[0_0_10px_rgba(220,38,38,0.05)]" 
                                                             title="Unit {{ $row }}{{ $seat->seat_number }}">
                                                             <div class="absolute bottom-1 left-1 right-1 h-1 bg-red-600/20 rounded-full"></div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <span class="text-[11px] text-gray-700 font-black w-6 text-left uppercase italic group-hover/row:text-red-500 transition-colors">{{ $row }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="px-8 py-4 bg-[#161616]/50 flex justify-center border-t border-gray-800/30">
                                <p class="text-[9px] text-gray-600 font-bold uppercase tracking-[0.2em]">Auditorium Infrastructure Verified</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    ::-webkit-scrollbar { height: 4px; width: 4px; }
    ::-webkit-scrollbar-track { background: #0a0a0a; }
    ::-webkit-scrollbar-thumb { background: #222; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #ff0000; }
</style>
@endsection