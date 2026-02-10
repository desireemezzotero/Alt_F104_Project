@extends('.layouts.master')

@section('component')
    <div class="relative min-h-screen bg-white flex flex-col lg:flex-row overflow-hidden">

        {{-- COLONNA SINISTRA: Branding & Team (Visibile solo su LG) --}}
        <div
            class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-gray-50 to-blue-50 border-r border-gray-100 items-center justify-center p-12">
            {{-- Decorazioni di Sfondo --}}
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-100/40 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-indigo-100/40 rounded-full blur-3xl"></div>

            <div class="relative z-10 w-full max-w-lg flex flex-col items-center lg:items-start">

                {{-- LOGO CENTRATO (con animazione Tailwind nativa) --}}
                <div
                    class="mb-10 p-6 bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-white animate-bounce flex items-center justify-center self-center">
                    <img src="{{ asset('img/logo-bg-remove.png') }}" class="h-24 w-auto object-contain" alt="Logo Progetto">
                </div>

                <div class="mb-12 text-center lg:text-left">
                    <h3 class="text-blue-600 font-bold uppercase tracking-[0.3em] text-[10px] mb-4">Project Management
                        System</h3>
                    <h1 class="text-5xl font-black text-gray-900 leading-tight mb-6">
                        Accedi alla <br> <span class="text-blue-500 text-6xl">Piattaforma</span>
                    </h1>
                    <p class="text-gray-500 text-lg leading-relaxed">Gestione avanzata dei task, monitoraggio delle
                        pubblicazioni scientifiche e coordinamento del team di ricerca.</p>
                </div>

                {{-- Preview Team --}}
                <div class="space-y-5 w-full">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 text-center lg:text-left">
                        Insieme al Team di Ricerca</p>
                    <div class="flex -space-x-3 justify-center lg:justify-start">
                        @php
                            $teamImgs = [
                                'lacorte.jpeg',
                                'lamorgese.jpeg',
                                'milone.jpeg',
                                'pizzolante.jpeg',
                                'trinchero.jpeg',
                                'zullo.jpeg',
                            ];
                        @endphp
                        @foreach ($teamImgs as $img)
                            <div
                                class="h-14 w-14 rounded-2xl border-4 border-white shadow-sm overflow-hidden bg-gray-200 hover:z-20 transform hover:-translate-y-2 transition-all duration-300">
                                <img src="{{ asset('img/' . $img) }}" class="w-full h-full object-cover" alt="Team">
                            </div>
                        @endforeach
                        <div
                            class="h-14 w-14 rounded-2xl border-4 border-white shadow-sm bg-blue-600 flex items-center justify-center text-white text-xs font-black">
                            +
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLONNA DESTRA: Form di Login --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 bg-white relative">

            {{-- Logo Mobile --}}
            <div class="absolute top-10 left-10 lg:hidden">
                <img src="{{ asset('img/logo-bg-remove.png') }}" class="h-12 w-auto" alt="Logo">
            </div>

            <div class="w-full max-w-md">
                <div class="mb-12">
                    <h2 class="text-4xl font-black text-gray-900 tracking-tighter mb-3">Login</h2>
                    <p class="text-gray-400 font-medium">Inserisci le tue credenziali per accedere all'area riservata.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="email"
                            class="block text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">E-mail
                            Istituzionale</label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-300 group-focus-within:text-blue-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                                class="block w-full pl-12 pr-6 py-5 bg-gray-50 border-2 border-gray-50 rounded-[2rem] text-gray-900 text-sm font-bold focus:ring-0 focus:border-blue-500 focus:bg-white transition-all outline-none"
                                placeholder="nome@esempio.it">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-1">
                            <label for="password"
                                class="block text-[10px] font-black uppercase tracking-widest text-gray-500">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-[10px] font-black text-blue-600 hover:text-blue-700 uppercase">Reset?</a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-300 group-focus-within:text-blue-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required
                                class="block w-full pl-12 pr-6 py-5 bg-gray-50 border-2 border-gray-50 rounded-[2rem] text-gray-900 text-sm font-bold focus:ring-0 focus:border-blue-500 focus:bg-white transition-all outline-none"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between px-2">
                        <label class="flex items-center group cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="w-5 h-5 rounded-lg border-gray-200 text-blue-600 focus:ring-0 transition-all">
                            <span
                                class="ml-3 text-xs text-gray-400 font-bold uppercase tracking-tighter group-hover:text-gray-600 transition-colors">Resta
                                collegato</span>
                        </label>
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="w-full bg-gray-900 text-white py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] text-[10px] hover:bg-blue-600 hover:shadow-2xl hover:shadow-blue-500/40 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                            Effettua l'accesso
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </form>

                <div class="mt-16 pt-8 border-t border-gray-50 text-center lg:text-left">
                    <p class="text-[9px] text-gray-300 font-black uppercase tracking-[0.3em]">© 2026 Alt_F104 Group • Secure
                        Research Portal</p>
                </div>
            </div>
        </div>
    </div>
@endsection
