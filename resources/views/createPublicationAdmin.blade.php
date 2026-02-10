@extends('.layouts.master')

@section('component')
    <div class="container mx-auto px-4 py-12 max-w-6xl">

        {{-- titolo --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                    Nuova <span class="text-blue-600">Pubblicazione</span>
                </h1>
                <p class="text-gray-500 mt-1 font-medium">Inserisci i dettagli tecnici e assegna il team di ricerca.</p>
            </div>

            <a href="{{ url()->previous() }}"
                class="flex items-center text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Torna indietro
            </a>
        </div>

        @include('components.component.publicationCreateAdmin')
    </div>
@endsection
