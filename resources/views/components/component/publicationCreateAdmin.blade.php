 <form action="{{ route('publication.store') }}" method="POST" enctype="multipart/form-data">
     @csrf

     <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

         {{-- titolo + descrizione + allegati --}}
         <div class="lg:col-span-2 space-y-6">

             {{-- titolo e descrizione --}}

             <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                 <div class="space-y-6">
                     <div>

                         <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-2">
                             Titolo della Ricerca
                         </label>

                         <input type="text" name="name" value="{{ old('name') }}"
                             class="block w-full px-5 py-4 rounded-2xl border-gray-100 bg-gray-50 text-gray-900 font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-gray-300"
                             placeholder="Es: Analisi dei sistemi distribuiti..." required>
                         @error('name')
                             <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                         @enderror
                     </div>

                     <div>
                         <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-2">
                             Descrizione</label>
                         <textarea name="description" rows="6"
                             class="block w-full px-5 py-4 rounded-2xl border-gray-100 bg-gray-50 text-gray-700 leading-relaxed focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-gray-300"
                             placeholder="Descrivi brevemente i risultati della pubblicazione..." required>{{ old('description') }}</textarea>
                     </div>
                 </div>
             </div>

             {{-- Allegati --}}
             <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">

                 <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-4">
                     Documentazione & Media
                 </label>

                 <div class="relative group">
                     <input type="file" name="attachments[]" multiple
                         class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                     <div
                         class="p-10 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50 group-hover:bg-blue-50 group-hover:border-blue-200 transition-all text-center">
                         <div
                             class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 text-blue-500 group-hover:scale-110 transition-transform">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-width="2"
                                     d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                             </svg>
                         </div>
                         <p class="text-sm font-bold text-gray-600">Trascina i file qui o clicca per sfogliare</p>
                         <p class="text-xs text-gray-400 mt-1">PDF, DOCX, Immagini (Max 5MB per file)</p>
                     </div>
                 </div>
             </div>
         </div>

         {{-- stato + autori --}}
         <div class="space-y-6">

             {{-- Stato --}}
             <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                 <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-4">Workflow
                     Status</label>
                 <select name="status"
                     class="w-full p-4 rounded-2xl border-gray-100 bg-gray-50 text-sm font-bold text-gray-700 focus:ring-blue-500 transition-all">
                     <option value="drafting" {{ old('status') == 'drafting' ? 'selected' : '' }}>📝 In Stesura
                     </option>
                     <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>✉️ Inviata
                     </option>
                     <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>✅ Accettata
                     </option>
                     <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>📚 Pubblicata
                     </option>
                 </select>
             </div>

             {{-- Autori --}}
             <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                 <div class="flex items-center justify-between mb-6">
                     <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em]">Autori
                         Assegnati</label>
                     <span class="bg-blue-100 text-blue-600 text-[10px] px-2 py-0.5 rounded-md font-black">TEAM</span>
                 </div>

                 <div
                     class="space-y-3 max-h-[400px] overflow-y-auto pr-2 border-r-2 border-transparent hover:border-gray-50 transition-all">
                     @foreach ($users as $user)
                         <div
                             class="flex items-center justify-between p-3 rounded-2xl bg-gray-50 border border-transparent hover:border-blue-100 transition-all group">
                             <div class="flex items-center gap-3">
                                 <input type="checkbox" name="authors[]" value="{{ $user->id }}"
                                     id="u_{{ $user->id }}"
                                     class="w-5 h-5 rounded-lg border-gray-300 text-blue-600 focus:ring-blue-500/20 transition-all cursor-pointer">
                                 <label for="u_{{ $user->id }}" class="cursor-pointer">
                                     <p class="text-xs font-bold text-gray-800 leading-none">{{ $user->name }}</p>
                                     <p class="text-[10px] text-gray-400 mt-1">{{ $user->role }}</p>
                                 </label>
                             </div>
                             <div class="flex flex-col items-end">
                                 <span class="text-[9px] font-black text-gray-300 uppercase mb-1">Pos.</span>
                                 <input type="number" name="positions[{{ $user->id }}]" value="1"
                                     min="1"
                                     class="w-10 p-1 text-center text-xs font-bold bg-white border-gray-200 rounded-lg focus:ring-blue-500">
                             </div>
                         </div>
                     @endforeach
                 </div>
             </div>

             {{-- Salva --}}
             <button type="submit"
                 class="w-full py-5 bg-blue-600 text-white rounded-3xl font-black text-sm uppercase tracking-widest hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-200 transition-all active:scale-[0.98]">
                 Pubblica Ricerca
             </button>
         </div>
     </div>
 </form>
