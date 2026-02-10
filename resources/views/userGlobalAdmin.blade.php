@extends('.layouts.master')

@section('component')
    <div class="container mx-auto px-6 py-12 max-w-7xl">

        {{-- hader --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-12 h-[2px] bg-blue-700"></span>
                    <span class="text-blue-700 font-black text-[10px] uppercase tracking-[0.4em]">Directory Risorse</span>
                </div>
                <h1 class="text-5xl font-black text-gray-900 tracking-tighter leading-tight">
                    Team <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-500 italic">Project</span>
                </h1>
                <p class="text-gray-400 font-medium text-lg italic">Gestione accessi e ruoli del personale autorizzato.</p>
            </div>

            {{-- bottone per aggiungere un nuovo membro --}}
            <button data-modal-target="create-user-modal" data-modal-toggle="create-user-modal"
                class="px-8 py-4 bg-gray-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-200 transition-all duration-300 flex items-center gap-3">
                <div
                    class="w-6 h-6 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span>Aggiungi Membro</span>
            </button>
        </div>

        {{-- membri --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($users as $user)
                <div
                    class="group relative bg-white rounded-[3rem] p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:border-blue-100 transition-all duration-500 overflow-hidden">

                    <div
                        class="absolute -top-10 -right-10 w-32 h-32 bg-blue-50 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-700 scale-0 group-hover:scale-150">
                    </div>

                    <div class="relative z-10">
                        {{-- icona + ruolo --}}
                        <div class="flex items-start justify-between mb-8">
                            <div
                                class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gray-900 to-gray-700 flex items-center justify-center text-white text-xl font-black shadow-lg group-hover:rotate-6 transition-transform duration-300">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <span
                                class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $user->role == 'Admin/PI' ? 'bg-blue-700 text-white shadow-lg shadow-blue-100' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-900 group-hover:text-white' }} transition-colors">
                                {{ $user->role }}
                            </span>
                        </div>

                        {{-- nome + email + elimina --}}
                        <div class="flex items-center justify-between group">

                            <div class="space-y-1">
                                <h3
                                    class="text-2xl font-black text-gray-900 tracking-tight group-hover:text-blue-700 transition-colors">
                                    {{ $user->name }}
                                </h3>
                                <div
                                    class="flex items-center gap-2 text-gray-400 group-hover:text-gray-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="2.5"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs font-bold">{{ $user->email }}</span>
                                </div>
                            </div>

                            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Sei sicuro di voler eliminare questo utente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="2.5"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('components.component.formUserAdmin')
@endsection
