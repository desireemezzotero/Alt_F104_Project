{{-- MODAL FORM (create-user-modal) --}}
<div id="create-user-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full bg-gray-900/40 backdrop-blur-md">

    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-[3.5rem] shadow-2xl overflow-hidden border border-gray-100">

            {{-- header --}}
            <div class="relative p-10 overflow-hidden border-b border-gray-50">
                <div
                    class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-50 to-transparent opacity-60">
                </div>
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <h3 class="text-4xl font-black tracking-tighter text-gray-900">Nuovo <span
                                class="text-blue-700">Utente</span></h3>
                        <p class="text-gray-400 font-bold mt-2 uppercase text-[10px] tracking-[0.2em]">Configurazione
                            credenziali</p>
                    </div>
                    <button type="button"
                        class="p-2 rounded-xl bg-gray-100 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all duration-300"
                        data-modal-hide="create-user-modal">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- form --}}
            <form action="{{ route('user.store') }}" method="POST" class="p-10">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- nome --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-2">Nome
                            Completo</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold text-gray-900 transition-all"
                            placeholder="Es. Mario Rossi">
                        @error('name')
                            <p class="text-red-500 text-[10px] font-bold ml-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- email --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-2">Indirizzo
                            Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold text-gray-900 transition-all"
                            placeholder="mario@esempio.it">
                        @error('email')
                            <p class="text-red-500 text-[10px] font-bold ml-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ruolo --}}
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-2">Ruolo
                            Sistema</label>
                        <p class="font-black text-gray-300 text-xs ml-2">
                            Sarà possibile assegnare successivamente un ruolo diverso nella pubblicazione o
                            progetto
                        </p>
                        <select name="role"
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold text-gray-900 appearance-none">
                            <option value="Researcher" {{ old('role') == 'Researcher' ? 'selected' : '' }}>🧪
                                Ricercatore</option>
                            <option value="Admin/PI" {{ old('role') == 'Admin/PI' ? 'selected' : '' }}>👑 Admin
                            </option>
                        </select>
                    </div>

                    {{-- password --}}
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold text-gray-900 placeholder="••••••••">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-2">Conferma
                            Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold text-gray-900 placeholder="••••••••">
                    </div>
                </div>

                <div class="mt-12 flex justify-end gap-4">
                    <button type="button" data-modal-hide="create-user-modal"
                        class="px-8 py-4 text-gray-400 font-black text-xs uppercase tracking-widest hover:text-gray-900 transition-colors">Annulla</button>
                    <button type="submit"
                        class="px-12 py-4 bg-blue-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-800 shadow-xl shadow-blue-200 transition-all transform active:scale-95">Crea
                        Utente</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script per riaprire il modal se la validazione fallisce --}}
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('create-user-modal');
            // Questo presuppone che tu stia usando Flowbite JS caricato globalmente
            const modal = new Modal(modalElement);
            modal.show();
        });
    </script>
@endif
