   <form id="edit-form" action="{{ route('publication.update', $publication->id) }}" method="POST"
       enctype="multipart/form-data" class="space-y-8">
       @csrf
       @method('PUT')

       {{-- titolo + descrizione --}}
       <div class="w-full bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
           <div class="space-y-6">

               {{-- titolo --}}
               <div>
                   <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-2">Titolo</label>
                   <input type="text" name="name" value="{{ old('name', $publication->name) }}"
                       class="block w-full px-5 py-4 rounded-2xl border-gray-100 bg-gray-50 text-gray-900 font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all"
                       required>
               </div>

               {{-- descrizione --}}
               <div>
                   <label
                       class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-2">Descrizione</label>
                   <textarea name="description" rows="4"
                       class="block w-full px-5 py-4 rounded-2xl border-gray-100 bg-gray-50 text-gray-700 leading-relaxed focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all"
                       required>{{ old('description', $publication->description) }}</textarea>
               </div>
           </div>
       </div>

       {{-- autori + stato --}}
       <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

           {{-- autori --}}
           <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
               <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-4">Team
                   Autori
               </label>

               <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                   @foreach ($users as $user)
                       @php
                           $author = $publication->authors->find($user->id);
                           $isAuthor = !is_null($author);
                           $position = $isAuthor ? $author->pivot->position : 1;
                       @endphp
                       <div
                           class="flex items-center justify-between p-3 rounded-2xl bg-gray-50 border border-transparent hover:border-blue-100 transition-all">
                           <div class="flex items-center gap-3">
                               <input type="checkbox" name="authors[]" value="{{ $user->id }}"
                                   id="u{{ $user->id }}" {{ $isAuthor ? 'checked' : '' }}
                                   class="w-5 h-5 rounded-lg border-gray-300 text-blue-600">
                               <label for="u{{ $user->id }}" class="text-xs font-bold text-gray-800 cursor-pointer">
                                   {{ $user->name }}
                               </label>
                           </div>
                           <div class="flex items-center gap-2">
                               <span class="text-[9px] font-bold text-gray-400 uppercase">Pos.</span>
                               <input type="number" name="positions[{{ $user->id }}]" value="{{ $position }}"
                                   min="1"
                                   class="w-10 p-1 text-center text-xs font-bold bg-white border-gray-200 rounded-lg">
                           </div>
                       </div>
                   @endforeach
               </div>
           </div>

           {{-- stato --}}
           <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
               <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-4">Stato
                   Pubblicazione
               </label>

               <div class="space-y-1">
                   @php
                       $statuses = [
                           'drafting' => '📝 Drafting',
                           'submitted' => '✉️ Submitted',
                           'accepted' => '✅ Accepted',
                           'published' => '📚 Published',
                       ];
                   @endphp

                   @foreach ($statuses as $val => $label)
                       <label
                           class="flex items-center p-2 rounded-xl hover:bg-blue-50/50 cursor-pointer transition-colors group">
                           <input type="radio" name="status" value="{{ $val }}"
                               {{ $publication->status == $val ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-offset-0">

                           <span
                               class="ml-3 text-sm font-bold {{ $publication->status == $val ? 'text-blue-600' : 'text-gray-600' }} group-hover:text-blue-600 transition-colors">
                               {{ $label }}
                           </span>
                       </label>
                   @endforeach
               </div>
           </div>
       </div>

       {{-- Allegati --}}
       <div class="w-full bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
           <h2 class="text-sm font-bold text-gray-800 mb-6 flex items-center gap-2">
               <span class="w-1.5 h-4 bg-blue-500 rounded-full"></span>
               Gestione Documentazione
           </h2>

           {{-- Allegati Esistenti --}}
           @if ($publication->attachments->count() > 0)
               <div class="mb-8">
                   <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-4">File
                       Attuali</label>
                   <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                       @foreach ($publication->attachments as $attachment)
                           <div class="group relative bg-gray-50 border border-gray-100 p-2 rounded-2xl transition-all">
                               @if (Str::endsWith($attachment->file_path, ['.jpg', '.jpeg', '.png', '.gif']))
                                   <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                       class="w-full h-24 object-cover rounded-xl">
                               @else
                                   <div class="w-full h-24 flex items-center justify-center bg-gray-200 rounded-xl">
                                       <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                           viewBox="0 0 24 24">
                                           <path
                                               d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                       </svg>
                                   </div>
                               @endif
                               <button type="button"
                                   onclick="if(confirm('Eliminare?')) document.getElementById('delete-att-{{ $attachment->id }}').submit();"
                                   class="absolute -top-2 -right-2 bg-red-500 text-white p-1.5 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                   <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                       <path stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                                   </svg>
                               </button>
                               <p class="text-[9px] font-bold text-gray-400 mt-2 truncate px-1 text-center">
                                   {{ $attachment->file_name }}</p>
                           </div>
                       @endforeach
                   </div>
               </div>
           @endif

           {{-- nuovi allegati --}}
           <div
               class="border-2 border-dashed border-gray-100 rounded-2xl p-6 bg-gray-50 group hover:border-blue-200 transition-all">
               <label
                   class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-2 text-center group-hover:text-blue-400 transition-colors cursor-pointer">
                   Trascina qui i nuovi file o clicca per selezionarli
               </label>
               <input type="file" name="attachments[]" multiple
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all">
           </div>
       </div>
   </form>

   {{-- eliminazione allegati --}}
   @foreach ($publication->attachments as $attachment)
       <form id="delete-att-{{ $attachment->id }}" action="{{ route('fileDestroy', $attachment->id) }}" method="POST"
           class="hidden">
           @csrf @method('DELETE')
       </form>
   @endforeach
