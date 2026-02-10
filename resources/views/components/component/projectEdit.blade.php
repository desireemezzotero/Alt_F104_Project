 {{-- modulo modifica progetto --}}
 <div id="edit-project-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
     <div class="relative p-4 w-full max-w-6xl max-h-full"> {{-- Allargato a 6xl per il layout a due colonne --}}
         <div class="relative bg-white border border-gray-200 rounded-[3rem] shadow-2xl overflow-hidden text-left">

             {{-- Header --}}
             <div class="flex items-center justify-between p-8 border-b border-gray-50">
                 <div>
                     <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-500">Impostazioni
                         Progetto</span>
                     <h3 class="text-2xl font-black tracking-tighter uppercase text-gray-900 leading-none mt-1">
                         {{ $project->name }}
                     </h3>
                 </div>
                 <button type="button" data-modal-hide="edit-project-modal"
                     class="text-gray-400 hover:bg-gray-100 rounded-2xl w-12 h-12 flex justify-center items-center transition-all">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                     </svg>
                 </button>
             </div>

             <div class="p-8">
                 <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                     {{-- titolo + descrizione + stato + data fine --}}
                     <div class="lg:col-span-7">
                         <form action="{{ route('project.update', $project) }}" method="POST"
                             enctype="multipart/form-data" class="space-y-6">
                             @csrf @method('PUT')

                             <div class="space-y-6">
                                 {{-- tiolo --}}
                                 <div>
                                     <label
                                         class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-2">
                                         Titolo Progetto
                                     </label>

                                     <input type="text" name="name" value="{{ old('name', $project->name) }}"
                                         class="block w-full bg-gray-50 border-none rounded-[1.5rem] p-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all">
                                 </div>

                                 {{-- descrizione --}}
                                 <div>
                                     <label
                                         class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-2">
                                         Descrizione
                                     </label>
                                     <textarea name="description" rows="5"
                                         class="block w-full bg-gray-50 border-none rounded-[1.5rem] p-4 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 transition-all">{{ old('description', $project->description) }}</textarea>
                                 </div>

                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                     {{-- stato --}}
                                     <div class="bg-gray-50 rounded-[1.5rem] p-4">
                                         <label
                                             class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Stato</label>
                                         <select name="status"
                                             class="block w-full bg-transparent border-none p-0 text-sm font-bold text-gray-900 focus:ring-0">
                                             <option value="active"
                                                 {{ $project->status == 'active' ? 'selected' : '' }}>● Attivo
                                             </option>
                                             <option value="on_hold"
                                                 {{ $project->status == 'on_hold' ? 'selected' : '' }}>○ In
                                                 Pausa</option>
                                             <option value="completed"
                                                 {{ $project->status == 'completed' ? 'selected' : '' }}>✔
                                                 Completato</option>
                                         </select>
                                     </div>

                                     {{-- data fine --}}
                                     <div class="bg-gray-50 rounded-[1.5rem] p-4">
                                         <label
                                             class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Deadline</label>
                                         <input type="date" name="end_date"
                                             value="{{ old('end_date', $project->end_date) }}"
                                             class="block w-full bg-transparent border-none p-0 text-sm font-bold text-gray-900 focus:ring-0">
                                     </div>
                                 </div>

                                 {{-- nuovi allegati --}}
                                 <div class="relative group">
                                     <label
                                         class="block text-[10px] font-black uppercase tracking-widest text-blue-500 mb-2 ml-2">Aggiungi
                                         File</label>
                                     <div
                                         class="flex items-center w-full bg-blue-50/50 border-2 border-dashed border-blue-100 rounded-[1.5rem] p-4 group-hover:bg-blue-50 transition-all">
                                         <input type="file" name="attachments[]" multiple
                                             class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white cursor-pointer">
                                     </div>
                                 </div>
                             </div>

                             <div class="flex items-center gap-3 pt-4">
                                 <button type="submit"
                                     class="flex-1 px-8 py-4 bg-gray-900 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-blue-600 transition-all">
                                     Salva Tutte le Modifiche
                                 </button>
                                 <button data-modal-hide="edit-project-modal" type="button"
                                     class="px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-gray-200 transition-all">
                                     Annulla
                                 </button>
                             </div>
                         </form>
                     </div>

                     {{-- allegati già esistenti --}}
                     <div class="lg:col-span-5 bg-gray-50/50 rounded-[2rem] p-6 border border-gray-100">
                         <div class="flex items-center justify-between mb-6">
                             <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">File
                                 & Documenti</label>
                             <span
                                 class="bg-white px-3 py-1 rounded-full text-[10px] font-bold text-gray-500 shadow-sm">
                                 {{ $project->attachments->count() }} elementi
                             </span>
                         </div>

                         <div class="grid grid-cols-2 gap-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                             @forelse ($project->attachments as $attachment)
                                 <div
                                     class="group relative bg-white p-3 rounded-2xl shadow-sm border border-gray-100 transition-all hover:shadow-md">
                                     @php $extension = pathinfo($attachment->file_path, PATHINFO_EXTENSION); @endphp

                                     <div
                                         class="aspect-square w-full overflow-hidden rounded-xl mb-2 bg-gray-50 flex items-center justify-center">
                                         @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                             <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                                 class="w-full h-full object-cover">
                                         @else
                                             <div class="flex flex-col items-center">
                                                 <svg class="w-8 h-8 text-blue-400 mb-1" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                     <path
                                                         d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                                 </svg>
                                                 <span
                                                     class="text-[10px] font-black text-blue-600">{{ strtoupper($extension) }}</span>
                                             </div>
                                         @endif
                                     </div>

                                     <div class="flex items-center justify-between gap-2 px-1">
                                         <p class="text-[9px] font-bold text-gray-700 truncate flex-1">
                                             {{ $attachment->file_name }}
                                         </p>
                                         {{-- eliminare --}}
                                         <form action="{{ route('fileDestroy', $attachment->id) }}" method="POST">
                                             @csrf @method('DELETE')
                                             <button type="button"
                                                 onclick="if(confirm('Eliminare definitivamente questo file?')) { this.closest('form').submit(); }"
                                                 class="text-gray-300 hover:text-red-500 transition-colors">
                                                 <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                     <path stroke-width="2"
                                                         d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                 </svg>
                                             </button>
                                         </form>
                                     </div>
                                 </div>
                             @empty
                                 <div class="col-span-2 py-12 flex flex-col items-center justify-center text-gray-300">
                                     <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                         <path stroke-width="1.5"
                                             d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                     </svg>
                                     <span class="text-[10px] font-black uppercase tracking-widest">Nessun
                                         allegato</span>
                                 </div>
                             @endforelse
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
