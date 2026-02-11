@extends('.layouts.master')

@section('component')
    <div
        class="h-screen max-h-screen w-full bg-[#f0f2f5] p-4 lg:p-6 overflow-hidden flex flex-col gap-6 font-sans antialiased text-gray-900">

        {{-- header --}}
        <div
            class="relative shrink-0 overflow-hidden bg-white/70 backdrop-blur-xl border border-white/40 rounded-[2.5rem] p-6 lg:p-8 shadow-2xl shadow-gray-200/50 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="z-10 text-center md:text-left">
                <div class="flex items-center gap-3 mb-1 justify-center md:justify-start">
                    <span class="h-2 w-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Situazione attuale</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-black tracking-tighter">
                    Bentornato <span class="text-blue-600">{{ explode(' ', $user->name)[0] }}</span>
                </h1>
            </div>

            {{-- barra con percentuale --}}
            <div class="z-10 w-full md:w-1/2 lg:w-1/3 space-y-3">
                <div class="flex justify-between items-end px-2">
                    <span class="text-[9px] font-black uppercase text-gray-400 tracking-widest">Stato avanzamento
                        Task</span>
                    <span class="text-2xl font-black italic text-blue-600">{{ round($operationalFlow) }}%</span>
                </div>
                <div class="h-4 w-full bg-gray-200/50 rounded-full p-1 shadow-inner">
                    <div class="h-full bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-400 rounded-full shadow-[0_0_15px_rgba(37,99,235,0.3)] transition-all duration-1000 ease-out"
                        style="width: {{ $operationalFlow }}%">
                    </div>
                </div>
            </div>

            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-blue-100 rounded-full blur-[100px] opacity-60"></div>
        </div>


        {{-- notifiche + pubblicaizoni + progetti attivi e completati --}}
        <div class="flex-1 grid grid-cols-1 lg:grid-cols-12 gap-6 min-h-0">

            {{-- notifiche + pubblicazioni --}}
            <div class="lg:col-span-3 flex flex-col gap-6 min-h-0">

                {{-- notifiche --}}
                <section
                    class="flex-1 bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-100 flex flex-col min-h-0">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-red-500 mb-6 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Notifiche Immediate
                    </h3>
                    <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-4">
                        @forelse ($criticalAlerts as $alert)
                            <div
                                class="group p-4 bg-gray-50 rounded-3xl hover:bg-red-50 transition-all border border-transparent hover:border-red-100">
                                <p class="text-[8px] font-black text-red-400 uppercase mb-1">{{ $alert->end_date }}</p>
                                <h4 class="text-sm font-bold leading-tight text-gray-800 group-hover:text-red-700">
                                    {{ $alert->name }}</h4>
                            </div>
                        @empty
                            <div
                                class="h-full flex items-center justify-center text-gray-300 italic text-[10px] uppercase tracking-widest font-bold">
                                nessuna notifica</div>
                        @endforelse
                    </div>
                </section>

                {{-- pubblicazioni --}}
                <section class="h-1/3 bg-gray-900 rounded-[2.5rem] p-6 shadow-xl flex flex-col min-h-0">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-400 mb-4 italic">Pubblicazioni
                    </h3>
                    <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-2">
                        @foreach ($manuscripts as $doc)
                            <a href="{{ route('publication.show', $doc->id) }}"
                                class="block p-3 rounded-2xl hover:bg-white/10 transition-all border border-white/5 group">
                                <p class="text-xs font-medium text-gray-400 group-hover:text-white line-clamp-1 italic">/
                                    {{ $doc->title }}</p>
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>
            {{-- progetti --}}
            @include('components.component.dashboardUser')
        </div>
    </div>
@endsection
