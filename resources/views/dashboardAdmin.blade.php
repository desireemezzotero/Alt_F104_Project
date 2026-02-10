@extends('.layouts.master')

@section('component')
    <div class="container mx-auto px-6 py-12 max-w-7xl">

        {{-- TITOLO + NUOVO DOCUEMENTO --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">

            {{-- titolo --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 rounded-2xl bg-blue-700 flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-width="2.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <span class="text-blue-700 font-black text-xs uppercase tracking-[0.3em]">Visione Esclusiva</span>
                </div>
                <h1 class="text-5xl font-black text-gray-900 tracking-tighter leading-tight">
                    Bentornato, <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">{{ explode(' ', auth()->user()->name)[0] }}</span>
                </h1>
                <p class="text-gray-400 font-medium text-lg mt-2">Ecco lo stato attuale globale</p>
            </div>

            {{-- crea nuovo --}}
            <div class="flex gap-3">
                <button data-modal-target="creation-hub" data-modal-toggle="creation-hub"
                    class="px-8 py-4 bg-gray-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-200 transition-all duration-300 flex items-center gap-2"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    Crea Nuovo
                </button>
            </div>
        </div>

        {{-- PROGETTI + TASK + TEAM --}}
        @include('components.component.dashboardAdminPart')

        {{-- allegati e db --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- allegati --}}
            <div class="lg:col-span-1 bg-blue-400 rounded-[2.5rem] p-8 text-white shadow-xl">
                <h4 class="text-[10px] font-black uppercase opacity-60 tracking-widest mb-6">Documenti allegati</h4>
                <div class="flex items-end gap-4 mb-4">
                    <span class="text-5xl font-black">{{ $stats['attachments'] }}</span>
                    <span class="text-xs font-bold opacity-60 pb-2 uppercase tracking-tighter">File Caricati</span>
                </div>
            </div>

            {{-- pubblicazioni --}}
            <div
                class="lg:col-span-3 bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <h3 class="text-xl font-black text-gray-900">Pubblicazioni Globali</h3>
                    <p class="text-gray-400 font-medium text-sm">Visualizza e gestisci l'intero database delle
                        pubblicazioni.</p>
                </div>
                <a href="{{ route('publication.indexAdmin') }}" class="flex items-center gap-4 group">
                    <span
                        class="text-sm font-black uppercase tracking-widest group-hover:text-blue-700 transition-colors">Esplora
                        Database</span>
                    <div
                        class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>

    </div>

    @include('components.component.dashboardAdminPopUp')
@endsection
