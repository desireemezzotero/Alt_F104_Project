@extends('.layouts.master')

@section('component')
    <div class="container mx-auto px-4 py-12 max-w-7xl">

        {{-- header --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="w-12 h-[2px] bg-blue-600"></span>
                    <span class="text-blue-600 font-black text-xs uppercase tracking-[0.4em]">Hub Editoriale</span>
                </div>
                <h1 class="text-5xl font-black text-gray-900 tracking-tighter">
                    Pubblicazioni <span class="text-blue-600">Globali</span>
                </h1>
            </div>

            <a href="{{ route('publication.create') }}"
                class="px-8 py-4 bg-gray-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-600 transition-all shadow-2xl shadow-gray-200">
                + Nuova Pubblicazione
            </a>
        </div>

        {{-- card --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            {{-- singola card con stato + titolo + descrizione + teams + progetti + bottone --}}
            @forelse($publications as $publication)
                {{-- stato, titolo, descrizione, temas, progetti  --}}
                <div
                    class="group relative bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-blue-900/5 transition-all duration-500 hover:-translate-y-2">

                    {{-- stato della pubblicazione --}}
                    <div class="mb-6">
                        @php
                            $statusLabel =
                                [
                                    'drafting' => 'In Stesura',
                                    'submitted' => 'Inviato',
                                    'published' => 'Pubblicato',
                                    'accepted' => 'Accettato',
                                ][$publication->status] ?? $publication->status;
                        @endphp
                        <span
                            class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-blue-50 text-blue-600">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    {{-- titolo + descriuzione --}}
                    <div class="mb-8">
                        <h2
                            class="text-2xl font-black text-gray-900 group-hover:text-blue-600 transition-colors mb-3 leading-tight">
                            {{ $publication->name }}
                        </h2>
                        <p class="text-sm text-gray-400 font-medium line-clamp-2 leading-relaxed">
                            {{ $publication->description }}
                        </p>
                    </div>

                    {{-- teams e progetti --}}
                    <div class="flex items-center justify-between pt-6 border-t border-gray-50">

                        {{-- autori --}}
                        <div class="flex flex-col gap-2">
                            <span class="text-[9px] font-black uppercase text-gray-400 tracking-[0.2em]">
                                Autori
                            </span>

                            <div class="flex -space-x-2">
                                @foreach ($publication->authors->take(3) as $author)
                                    <div class="w-8 h-8 rounded-full bg-gray-50 border-2 border-white flex items-center justify-center text-[10px] font-black text-blue-600 shadow-sm transition-transform hover:-translate-y-1"
                                        title="{{ $author->name }}">
                                        {{ strtoupper(substr($author->name, 0, 1)) }}
                                    </div>
                                @endforeach

                                @if ($publication->authors->count() > 3)
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-600 border-2 border-white flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                        +{{ $publication->authors->count() - 3 }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- progetti --}}
                        <div class="text-right">
                            <span class="text-[10px] font-black uppercase text-gray-300 tracking-widest">
                                {{ $publication->projects->count() }} Progetti
                            </span>
                        </div>

                    </div>


                    {{-- visualizza  --}}
                    <button data-modal-target="modal-{{ $publication->id }}"
                        data-modal-toggle="modal-{{ $publication->id }}"
                        class="absolute inset-0 z-10 rounded-[2.5rem] cursor-pointer" type="button">
                        <span class="sr-only">Visualizza dettagli</span>
                    </button>
                </div>

                {{-- pop up --}}
                @include('components.component.publicationShowAdmin')

            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-gray-300 font-black uppercase tracking-widest">Nessun documento trovato</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
