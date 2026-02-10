 {{-- CREAZIONE DI NUOVE PUBBLICAIZONI O UTENTI --}}
 <div id="creation-hub" tabindex="-1"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full bg-gray-900/20 backdrop-blur-sm">
     <div class="relative p-4 w-full max-w-xl max-h-full">
         <div class="relative bg-white rounded-[3rem] shadow-2xl border border-gray-100 p-2 overflow-hidden">

             <button type="button"
                 class="absolute top-6 right-6 text-gray-400 hover:text-gray-900 transition-colors z-20"
                 data-modal-hide="creation-hub">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                 </svg>
             </button>

             {{-- pubblicazioni ed utenti --}}
             <div class="p-8 md:p-10 text-center">
                 <div class="mb-8">
                     <h3 class="text-3xl font-black text-gray-900 tracking-tighter">Cosa vuoi <span
                             class="text-blue-700">creare</span>?</h3>
                     <p class="text-gray-400 font-medium mt-2 text-sm uppercase tracking-widest">
                         Seleziona una categoria per procedere
                     </p>
                 </div>


                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                     {{-- progetti --}}
                     <a href="{{ route('publication.create') }}"
                         class="group p-8 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-blue-700 hover:border-blue-600 transition-all duration-500 text-left relative overflow-hidden">

                         <div class="relative z-10">
                             <div
                                 class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-700 shadow-sm mb-6 group-hover:scale-110 transition-transform duration-500">
                                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-width="2.5"
                                         d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                 </svg>
                             </div>

                             <h4
                                 class="text-xl font-black text-gray-900 group-hover:text-white transition-colors tracking-tight">
                                 Pubblicazione
                             </h4>

                             <p class="text-gray-400 group-hover:text-blue-100 text-xs mt-2 leading-relaxed">
                                 Aggiungi documenti, ricerche o articoli editoriali
                             </p>
                         </div>
                     </a>


                     {{-- nuovo utente --}}
                     <button data-modal-hide="creation-hub" data-modal-target="create-user-modal"
                         data-modal-toggle="create-user-modal"
                         class="group p-8 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-gray-900 hover:border-gray-800 transition-all duration-500 text-left w-full">
                         <div class="relative z-10">
                             <div
                                 class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-900 shadow-sm mb-6 group-hover:scale-110 transition-transform duration-500">
                                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-width="2.5"
                                         d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                 </svg>
                             </div>
                             <h4
                                 class="text-xl font-black text-gray-900 group-hover:text-white transition-colors tracking-tight">
                                 Team Member</h4>
                             <p class="text-gray-400 group-hover:text-gray-400 text-xs mt-2 leading-relaxed">Registra un
                                 nuovo collaboratore.</p>
                         </div>
                     </button>


                 </div>
             </div>
         </div>
     </div>
 </div>

 {{-- FORM CREAZIONE UTENTE --}}
 <div id="create-user-modal" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full bg-gray-900/40 backdrop-blur-md">

     <div class="relative p-4 w-full max-w-4xl max-h-full">
         <div class="relative bg-white rounded-[3.5rem] shadow-2xl overflow-hidden border border-gray-100">

             {{-- Header --}}
             <div class="relative p-10 overflow-hidden border-b border-gray-50">
                 <div
                     class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-50 to-transparent opacity-60">
                 </div>

                 <div class="relative z-10 flex justify-between items-start">
                     <div>
                         <h3 class="text-4xl font-black tracking-tighter text-gray-900">
                             Nuovo <span class="text-blue-700">Utente</span>
                         </h3>
                         <p class="text-gray-400 font-bold mt-2 uppercase text-[10px] tracking-[0.2em]">
                             Configurazione credenziali di accesso
                         </p>
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

             {{-- form  --}}
             <form action="{{ route('user.store') }}" method="POST" class="p-10">
                 @csrf

                 <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                     {{-- nome --}}
                     <div class="space-y-2">
                         <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-2">Nome
                             Completo</label>
                         <input type="text" name="name" value="{{ old('name') }}" required
                             class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold text-gray-900 placeholder-gray-300 transition-all"
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
                             class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold text-gray-900 placeholder-gray-300 transition-all"
                             placeholder="mario@esempio.it">
                         @error('email')
                             <p class="text-red-500 text-[10px] font-bold ml-2">{{ $message }}</p>
                         @enderror
                     </div>

                     {{-- ruolo in generale --}}
                     <div class="md:col-span-2 space-y-2">
                         <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-2">Ruolo
                             Sistema </label>
                         <p class="font-black text-gray-300 text-xs ml-2">
                             Sarà possibile assegnare successivamente un ruolo diverso nella pubblicazione o
                             progetto
                         </p>

                         <select name="role"
                             class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold text-gray-900 appearance-none">
                             <option value="Researcher" {{ old('role') == 'Researcher' ? 'selected' : '' }}>🧪
                                 Ricercatore (Researcher)</option>
                             <option value="Admin/PI" {{ old('role') == 'Admin/PI' ? 'selected' : '' }}>👑 Admin /
                                 Principal Investigator</option>
                         </select>
                         @error('role')
                             <p class="text-red-500 text-[10px] font-bold ml-2">{{ $message }}</p>
                         @enderror
                     </div>

                     {{-- password --}}
                     <div class="space-y-2">
                         <label
                             class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-2">Password</label>
                         <input type="password" name="password" required
                             class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold text-gray-900 placeholder-gray-300 transition-all"
                             placeholder="Minimo 8 caratteri">
                     </div>

                     {{-- ripetizione password --}}
                     <div class="space-y-2">
                         <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-2">Conferma
                             Password</label>
                         <input type="password" name="password_confirmation" required
                             class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold text-gray-900 placeholder-gray-300 transition-all"
                             placeholder="Ripeti la password">
                     </div>

                     {{-- errore password --}}
                     @error('password')
                         <div class="md:col-span-2">
                             <p class="text-red-500 text-[10px] font-bold ml-2 italic">{{ $message }}</p>
                         </div>
                     @enderror

                     {{-- footer aggiuntivo --}}
                     <div class="md:col-span-2 bg-blue-50/50 p-6 rounded-[2rem] border border-blue-100/50 mt-2">
                         <div class="flex items-start gap-4">
                             <div
                                 class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-width="3"
                                         d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0 1 18 0z" />
                                 </svg>
                             </div>
                             <p class="text-xs text-blue-700 font-medium leading-relaxed">
                                 <strong>Nota di sicurezza:</strong> Una volta registrato, l'utente riceverà l'accesso
                                 immediato. Assicurati che l'email sia corretta per evitare blocchi di sistema.
                             </p>
                         </div>
                     </div>
                 </div>

                 {{-- conferma o annulla --}}
                 <div class="mt-12 flex justify-end gap-4">
                     <button type="button" data-modal-hide="create-user-modal"
                         class="px-8 py-4 text-gray-400 font-black text-xs uppercase tracking-widest hover:text-gray-900 transition-colors">
                         Annulla
                     </button>
                     <button type="submit"
                         class="px-12 py-4 bg-blue-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-800 shadow-xl shadow-blue-200 transition-all transform active:scale-95">
                         Crea Utente
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>
