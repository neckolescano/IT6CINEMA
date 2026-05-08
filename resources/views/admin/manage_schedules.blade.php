@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0a0a0a] text-white p-8 font-sans">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-12 border-b border-gray-800 pb-6">
            <div>
                <h1 class="text-4xl font-black tracking-tighter text-white uppercase italic">
                    Showtime <span class="text-red-600">Sequencing</span>
                </h1>
                <p class="text-gray-500 text-sm mt-2 tracking-widest uppercase">Programmatic Movie Distribution</p>
            </div>
            <a href="{{ route('schedules.create') }}" class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded-xl font-black uppercase text-xs tracking-widest transition-all">
                Add New Slot
            </a>
        </div>

        {{-- Success/Error Messages for Trigger Feedback --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-500 rounded-xl font-bold uppercase text-xs tracking-widest">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-500 rounded-xl font-bold uppercase text-xs tracking-widest">
                {{ $errors->first('error') }}
            </div>
        @endif

        <div class="bg-[#111] rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-black/50 border-b border-gray-800">
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Movie</th>
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Theater</th>
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Date</th>
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Time Slot</th>
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Price</th>
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    @foreach($schedules as $schedule)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="p-6">
                            <span class="font-black uppercase italic tracking-tighter text-lg text-white group-hover:text-red-500 transition-colors">
                                {{ $schedule->movie->movie_title }}
                            </span>
                        </td>

                        <td class="p-6">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                                {{ $schedule->cinema->cinema_name }}
                            </span>
                        </td>

                        <td class="p-6 text-sm font-mono text-gray-300">
                            {{ \Carbon\Carbon::parse($schedule->show_datetime)->format('M d, Y') }}
                        </td>

                        <td class="p-6">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-red-600/10 text-red-500 rounded text-[10px] font-bold">
                                    {{ \Carbon\Carbon::parse($schedule->show_datetime)->format('h:i A') }}
                                </span>
                            </div>
                        </td>

                        <td class="p-6 font-black text-white italic">
                            ₱{{ number_format($schedule->base_ticket_price, 2) }}
                        </td>

                        {{-- Action Buttons --}}
                        <td class="p-6">
                            <div class="flex justify-center items-center gap-4">
                                {{-- Edit Button --}}
                                <a href="{{ route('schedules.edit', $schedule->schedule_id) }}" class="text-gray-500 hover:text-blue-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('schedules.destroy', $schedule->schedule_id) }}" method="POST" onsubmit="return confirm('Remove this schedule?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-600 hover:text-red-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection