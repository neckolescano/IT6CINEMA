<div class="relative flex items-center justify-between w-full max-w-4xl mx-auto mb-12">
    {{-- Progress Line Background --}}
    <div class="absolute top-1/2 left-0 w-full h-0.5 bg-zinc-800 -translate-y-1/2 z-0"></div>
    
    @php
        $steps = [
            1 => ['name' => 'MOVIES', 'route' => 'movies.catalog'],
            2 => ['name' => 'DATE & TIME', 'route' => null],
            3 => ['name' => 'SEATS', 'route' => null],
            4 => ['name' => 'PAYMENT', 'route' => null],
            5 => ['name' => 'CONFIRMATION', 'route' => null],
        ];
    @endphp

    @foreach($steps as $num => $step)
        <div class="relative z-10 flex flex-col items-center">
            <div @class([
                'w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-500',
                'bg-red-600 text-white shadow-[0_0_15px_rgba(220,38,38,0.5)]' => $currentStep >= $num,
                'bg-zinc-900 border-2 border-zinc-800 text-zinc-500' => $currentStep < $num,
            ])>
                @if($currentStep > $num)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                @else
                    {{ $num }}
                @endif
            </div>
            <span @class([
                'absolute -bottom-7 text-[10px] font-black tracking-widest whitespace-nowrap uppercase',
                'text-red-600' => $currentStep == $num,
                'text-zinc-500' => $currentStep != $num,
            ])>
                {{ $step['name'] }}
            </span>
        </div>
    @endforeach
</div>