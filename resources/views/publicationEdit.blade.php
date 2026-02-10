@extends('.layouts.master')

@section('component')
    <div class="container mx-auto px-4 py-12 max-w-6xl">

        {{-- Header --}}
        <div class="flex flex-col justify-between mb-10 gap-4">
            <div class="container mx-auto px-6 py-4 flex items-center justify-between">
                <div class="items-center gap-4">
                    <span class="text-blue-600 font-black text-xs uppercase tracking-[0.2em]">Editor Pubblicazione</span>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight mt-1">
                        Modifica <span class="text-blue-600">Pubblicazione</span>
                    </h1>
                </div>

                <div class="flex flex-col items-end gap-1.5">
                    <a href="{{ route('publication.show', $publication->id) }}"
                        class="flex items-center text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Annulla e torna ai dettagli
                    </a>
                    {{-- Bottone collegato tramite ID del form --}}
                    <button type="submit" form="edit-form"
                        class="w-full px-6 py-3 bg-blue-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 shadow-lg hover:shadow-blue-200 transition-all active:scale-[0.98]">
                        Salva Modifiche
                    </button>
                </div>
            </div>
        </div>

        @include('components.component.publicationModifyAdmin')
    </div>
@endsection
