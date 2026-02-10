<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">

    {{-- progetti --}}
    <div
        class="lg:col-span-6 bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 group relative overflow-hidden">

        {{-- razzo --}}
        <div
            class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-30 group-hover:-translate-y-4 group-hover:-translate-x-4 transition-all duration-700 ease-out">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                class="w-40 h-40 text-blue-700 fill-currentColor rotate-12">
                <path
                    d="M128 320L24.5 320c-24.9 0-40.2-27.1-27.4-48.5L50 183.3C58.7 168.8 74.3 160 91.2 160l95 0c76.1-128.9 189.6-135.4 265.5-124.3 12.8 1.9 22.8 11.9 24.6 24.6 11.1 75.9 4.6 189.4-124.3 265.5l0 95c0 16.9-8.8 32.5-23.3 41.2l-88.2 52.9c-21.3 12.8-48.5-2.6-48.5-27.4L192 384c0-35.3-28.7-64-64-64l-.1 0zM400 160a48 48 0 1 0 -96 0 48 48 0 1 0 96 0z" />
            </svg>

        </div>

        <h3 class="text-[10px] font-black uppercase text-gray-400 tracking-[0.3em] mb-10">Progetti</h3>

        {{-- percentuale progetti --}}
        <div class="flex items-center gap-12">

            {{-- percetuale progetti attivi e quali completati --}}
            <div class="relative w-32 h-32">

                @php $projPerc = $stats['projects'] > 0 ? ($stats['projects_completed'] / $stats['projects']) * 100 : 0; @endphp
                <svg class="w-full h-full transform -rotate-90">
                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="12"
                        fill="transparent" class="text-gray-50" />
                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="12"
                        fill="transparent" class="text-blue-700" stroke-dasharray="364.4"
                        style="stroke-dashoffset: {{ 364.4 - (364.4 * $projPerc) / 100 }}" stroke-linecap="round" />
                </svg>

                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-black text-gray-900">{{ round($projPerc) }}%</span>
                </div>
            </div>

            {{-- progetti totali --}}
            <div>
                <p class="text-6xl font-black text-gray-900 tracking-tighter">{{ $stats['projects'] }}</p>
                <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Progetti Totali</p>
                <div class="mt-4 flex gap-2">
                    <span
                        class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">
                        {{ $stats['projects_completed'] }} Completati
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- task --}}
    <div
        class="lg:col-span-3 bg-blue-400 rounded-[3rem] p-10 shadow-2xl shadow-gray-400 flex flex-col justify-between group">
        <div class="flex justify-between items-start">
            <div
                class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-cyan-300 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>

            <span class="text-white font-black text-[10px] uppercase">task</span>
        </div>

        {{-- percentuale dei task --}}
        <div>
            <p class="text-6xl font-black text-white tracking-tighter mb-2">{{ $stats['tasks'] }}</p>
            @php $taskPerc = $stats['tasks'] > 0 ? ($stats['tasks_completed'] / $stats['tasks']) * 100 : 0; @endphp
            <div class="w-full h-1.5 bg-white rounded-full overflow-hidden">
                <div class="h-full bg-cyan-300 transition-all duration-1000" style="width: {{ $taskPerc }}%">
                </div>
            </div>
            <p class="text-[9px] font-bold text-white uppercase mt-4 tracking-widest">obiettivo:
                {{ round($taskPerc) }}% completato</p>
        </div>
    </div>

    {{-- team --}}
    <div class="lg:col-span-3 bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm flex flex-col justify-between hover:border-blue-200 transition-all cursor-pointer"
        onclick="window.location='{{ route('user.index') }}'">

        {{-- iconcine utenti --}}
        <div class="flex -space-x-3">
            @for ($i = 0; $i < 4; $i++)
                <div
                    class="w-10 h-10 rounded-full border-4 border-white bg-blue-50 flex items-center justify-center text-[10px] font-black text-blue-700">
                    U</div>
            @endfor
            <div
                class="w-10 h-10 rounded-full border-4 border-white bg-gray-900 flex items-center justify-center text-[10px] font-black text-white">
                +{{ $stats['users'] }}</div>
        </div>

        {{-- membri totali --}}
        <div>
            <p class="text-5xl font-black text-gray-900 tracking-tighter">{{ $stats['users'] }}</p>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Membri del Team</p>
            <div class="mt-4 text-blue-700 text-[10px] font-black uppercase flex items-center gap-1 group">
                Visualizza team
                <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </div>
        </div>

    </div>
</div>
