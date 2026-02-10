@extends('.layouts.master')

@section('component')
    <div class="relative bg-gradient-to-b from-gray-50 to-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                {{-- TEAM & PARTECIPANTI --}}
                <div class="order-2 lg:order-1">
                    <h3 class="text-blue-600 font-bold uppercase tracking-widest text-sm mb-4 text-center lg:text-left">
                        Membri del Progetto</h3>
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-8 leading-tight text-center lg:text-left">
                        Team di Ricerca <br> <span class="text-blue-500">& Collaboratori</span>
                    </h1>

                    {{-- immagine --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @php
                            $partecipanti = [
                                'Lacorte Giuseppe',
                                'Lamorgese Giancarlo',
                                'Milone Giuseppe',
                                'Pizzolante Angelo',
                                'Trinchero Francesco',
                                'Zullo Davide',
                            ];

                            $immagini = [
                                'lacorte.jpeg',
                                'lamorgese.jpeg',
                                'milone.jpeg',
                                'pizzolante.jpeg',
                                'trinchero.jpeg',
                                'zullo.jpeg',
                            ];
                        @endphp

                        @foreach ($partecipanti as $index => $nome)
                            <div
                                class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                {{-- CONTAINER IMMAGINE --}}
                                <div
                                    class="flex-shrink-0 h-20 w-20 bg-blue-100 rounded-full overflow-hidden border border-gray-200">
                                    <img src="{{ asset('img/' . $immagini[$index]) }}" alt="{{ $nome }}"
                                        class="w-full h-full object-cover">
                                </div>

                                <div class="ml-4">
                                    <p class="text-gray-900 font-semibold text-xs">{{ $nome }}</p>
                                    <p class="text-[10px] text-blue-500 font-bold uppercase tracking-tight">Team Member</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- LOGO  --}}
                <div class="order-1 lg:order-2 flex justify-center items-center">
                    <div class="w-full max-w-md">

                        <div
                            class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(8,_112,_184,_0.12)] border border-gray-50 flex justify-center items-center p-12 aspect-square">
                            <img src="{{ asset('img/logo-bg-remove.png') }}"
                                class="max-w-full h-auto max-h-48 md:max-h-64 object-contain" alt="Logo Progetto">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Sezione Card Pubblicazioni --}}
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Pubblicazioni Recenti</h2>
            <div class="ml-4 flex-grow h-px bg-gray-200"></div>
        </div>
        @include('.components.component.CardPublic')
    </div>
@endsection
