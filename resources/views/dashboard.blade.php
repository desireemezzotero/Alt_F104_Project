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
                                <a href="{{ route('project.show', $alert->id) }}">
                                    <h4 class="text-sm font-bold leading-tight text-gray-800 group-hover:text-red-700">
                                        {{ $alert->name }}</h4>
                                </a>
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
                        @foreach ($manuscripts as $pub)
                            @php $modalId = 'modal-pub-' . $pub->id; @endphp

                            {{-- Elemento della lista: ora è un button che apre il modal --}}
                            <button data-modal-target="{{ $modalId }}" data-modal-toggle="{{ $modalId }}"
                                class="w-full text-left block p-3 rounded-2xl hover:bg-white/10 transition-all border border-white/5 group">
                                <p class="text-xs font-medium text-gray-400 group-hover:text-white line-clamp-1 italic">
                                    {{ $pub->name }}
                                </p>
                            </button>

                            {{-- Il Modal per le pubblicazioni --}}
                            <div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
                                class="fixed top-0 left-0 right-0 z-[100] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">

                                <div class="relative w-full max-w-2xl max-h-full">
                                    <div
                                        class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">

                                        <div
                                            class="flex items-center justify-between p-5 border-b border-gray-100 bg-gray-50">
                                            <h3 class="text-xl font-bold text-gray-900">Dettagli Pubblicazione</h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                                                data-modal-hide="{{ $modalId }}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="p-8 space-y-6">
                                            <h4 class="text-2xl font-extrabold text-blue-600 leading-tight italic">
                                                {{ $pub->name }}
                                            </h4>

                                            <div class="text-gray-700 leading-relaxed text-base">
                                                {{ $pub->description }}
                                            </div>

                                            <div class="p-5 bg-blue-50 rounded-2xl border border-blue-100">
                                                <p class="text-xs font-bold text-blue-800 uppercase tracking-widest mb-4">
                                                    Autori e Ruoli</p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    @foreach ($pub->authors as $author)
                                                        <div
                                                            class="flex items-center text-sm bg-white p-2 rounded-lg border border-blue-50">
                                                            <span
                                                                class="font-bold text-gray-800">{{ $author->name }}</span>
                                                            <span
                                                                class="ml-2 text-blue-500 italic text-xs">({{ $author->role }})</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center p-6 space-x-3 border-t border-gray-100 bg-gray-50">
                                            <button data-modal-hide="{{ $modalId }}" type="button"
                                                class="flex-1 py-3 px-5 text-sm font-medium text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-all shadow-sm">
                                                Chiudi
                                            </button>

                                            @if (auth()->user()?->role === 'Admin/PI')
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('publication.edit', $pub->id) }}"
                                                        class="p-2 text-blue-600 bg-white border border-blue-100 hover:bg-blue-50 rounded-lg shadow-sm transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('publication.destroy', $pub->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Eliminare definitivamente?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="p-2 text-red-600 bg-white border border-red-100 hover:bg-red-50 rounded-lg shadow-sm transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
            {{-- progetti --}}
            @include('components.component.dashboardUser')
        </div>
    </div>
@endsection
