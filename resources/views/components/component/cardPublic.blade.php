<div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

        @foreach ($publicationPublished as $publication)
            @php
                $modalId = 'modal-pub-' . $publication->id;
                $cover = $publication->attachments->first();
            @endphp

            {{-- CARD DELLA PUBBLICAZIONE --}}
            <div
                class="group bg-white flex flex-col h-full border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">

                {{-- Immagine --}}
                <div class="relative overflow-hidden aspect-video bg-gray-100">

                    @if ($cover && $cover->file_path)
                        <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                            src="{{ asset('storage/' . $cover->file_path) }}" alt="{{ $publication->name }}" />
                    @else
                        <div
                            class="w-full h-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center text-blue-200">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    @endif

                </div>

                {{-- titolo e autori --}}
                <div class="p-6 flex flex-col flex-grow">
                    <span
                        class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 mb-3 self-start">
                        Pubblicazione
                    </span>

                    <h5
                        class="mb-3 text-xl font-bold text-gray-900 leading-snug group-hover:text-blue-600 transition-colors">
                        {{ $publication->name }}
                    </h5>


                    {{-- Sezione Autori --}}
                    <div class="mt-auto border-t border-gray-50 pt-4 mb-6">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Team</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach ($publication->authors->take(2) as $author)
                                <span
                                    class="text-[11px] bg-gray-50 text-gray-600 px-2 py-1 rounded-md border border-gray-100">
                                    {{ $author->name }}
                                </span>
                            @endforeach
                            @if ($publication->authors->count() > 2)
                                <span
                                    class="text-[11px] text-blue-500 font-bold self-center ml-1">+{{ $publication->authors->count() - 2 }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Pulsante Trigger Modal con Freccetta --}}
                    <button data-modal-target="{{ $modalId }}" data-modal-toggle="{{ $modalId }}"
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-sm focus:ring-4 focus:ring-blue-100 group"
                        type="button">
                        Visualizza dettagli
                        <svg class="w-4 h-4 ms-2 group-hover:translate-x-1 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Pop-up --}}
            <div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
                class="fixed top-0 left-0 right-0 z-[100] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">

                <div class="relative w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">

                        {{-- titolo --}}
                        <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-xl font-bold text-gray-900">Dettagli Pubblicazione</h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                                data-modal-hide="{{ $modalId }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>

                        {{-- descrizione + ruoli --}}
                        <div class="p-8 space-y-6">
                            <h4 class="text-3xl font-extrabold text-blue-600 leading-tight">
                                {{ $publication->name }}
                            </h4>

                            {{-- descrizione --}}
                            <div class="text-gray-600 leading-relaxed text-lg">
                                {{ $publication->description }}
                            </div>

                            {{-- team e ruoli --}}
                            <div class="p-5 bg-blue-50 rounded-2xl border border-blue-100">
                                <p class="text-xs font-bold text-blue-800 uppercase tracking-widest mb-4">Membri del
                                    Team e Ruoli</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach ($publication->authors as $author)
                                        <div
                                            class="flex items-center text-sm bg-white p-2 rounded-lg border border-blue-50">
                                            <span class="font-bold text-gray-800">{{ $author->name }}</span>
                                            <span
                                                class="ml-2 text-blue-500 italic text-xs">({{ $author->role }})</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        {{-- bottoni di chiusura, eliminazione, modifica ed aggiunta --}}
                        <div class="flex items-center p-6 space-x-3 border-t border-gray-100 rounded-b">
                            <button data-modal-hide="{{ $modalId }}" type="button"
                                class="flex-1 py-3 px-5 text-sm font-medium text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-all">
                                Chiudi
                            </button>

                            @if (auth()->user()?->role === 'Admin/PI')
                                <div class="flex items-center space-x-2">
                                    {{-- MODIFICA --}}
                                    <a href="{{ route('publication.edit', $publication->id) }}"
                                        class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors shadow-sm"
                                        title="Modifica">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>

                                    {{-- ELIMINA --}}
                                    <form action="{{ route('publication.destroy', $publication->id) }}" method="POST"
                                        onsubmit="return confirm('Sei sicuro di voler eliminare questa pubblicazione?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors shadow-sm"
                                            title="Elimina">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
</div>
