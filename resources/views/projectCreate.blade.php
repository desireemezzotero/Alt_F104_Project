@extends('.layouts.master')

@section('component')
    <div class="container mx-auto px-4 py-12 max-w-6xl">

        {{-- Header Bar --}}
        <div class="flex flex-col justify-between mb-10 gap-4">
            <div class="container mx-auto px-6 py-4 flex items-center justify-between rounded-3xl ">
                <div class="items-center gap-4">
                    <span class="text-blue-600 font-black text-xs uppercase tracking-[0.2em]">Nuovo Progetto</span>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight mt-1">
                        Crea <span class="text-blue-600">Progetto</span>
                    </h1>
                </div>

                {{-- crea e torna indietro  --}}
                <div class="flex flex-col items-end gap-1.5">
                    <a href="{{ url()->previous() }}"
                        class="flex items-center text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Torna indietro
                    </a>
                    <button type="submit" form="project-form"
                        class="px-8 py-3 bg-blue-600 text-white rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 shadow-lg hover:shadow-blue-100 transition-all active:scale-[0.98]">
                        Crea Progetto
                    </button>
                </div>
            </div>
        </div>

        @include('components.component.projectCreateAdmin')
    </div>
@endsection
