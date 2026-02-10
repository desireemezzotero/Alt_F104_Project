 {{-- FORM PER MODIFICARE LA TASK --}}
 <div id="edit-task-{{ $task->id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
     <div class="relative p-4 w-full max-w-2xl max-h-full">
         <div class="relative bg-white border border-gray-200 rounded-[2.5rem] shadow-2xl overflow-hidden text-left">
             <div class="flex items-center justify-between p-6 border-b border-gray-100">
                 <h3 class="text-xl font-black tracking-tighter uppercase text-gray-900">Modifica Task
                 </h3>
                 <button type="button" data-modal-hide="edit-task-{{ $task->id }}"
                     class="text-gray-400 hover:bg-gray-100 rounded-2xl w-9 h-9 flex justify-center items-center">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                     </svg>
                 </button>
             </div>
             <form action="{{ route('task.update', $task->id) }}" method="POST">
                 @csrf @method('PUT')
                 <div class="p-8 space-y-6">
                     @if ($isManager)
                         <div>
                             <label
                                 class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Titolo
                                 Task</label>
                             <input type="text" name="title" value="{{ $task->title }}"
                                 class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900">
                         </div>
                         <div class="grid grid-cols-2 gap-4">
                             <div>
                                 <label
                                     class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Stato</label>
                                 <select name="status"
                                     class="block w-full bg-blue-50 border-none rounded-2xl p-4 text-sm font-bold text-blue-600">
                                     <option value="to_do" {{ $task->status == 'to_do' ? 'selected' : '' }}>In attesa
                                     </option>
                                     <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>
                                         In corso
                                     </option>
                                     <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>
                                         Completato
                                     </option>
                                 </select>
                             </div>
                             <div>
                                 <label
                                     class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Tag</label>
                                 <select name="tag"
                                     class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900">
                                     <option value="lab" {{ $task->tag == 'lab' ? 'selected' : '' }}>
                                         Laboratorio</option>
                                     <option value="coding" {{ $task->tag == 'coding' ? 'selected' : '' }}>Sviluppo
                                         software</option>
                                     <option value="research" {{ $task->tag == 'research' ? 'selected' : '' }}>Ricerca
                                     </option>
                                     <option value="writing" {{ $task->tag == 'writing' ? 'selected' : '' }}>
                                         Documentazione
                                     </option>
                                 </select>
                             </div>
                         </div>
                         <div>
                             <label
                                 class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Descrizione</label>
                             <textarea name="description" rows="3"
                                 class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-medium text-gray-700">{{ $task->description }}</textarea>
                         </div>
                     @else
                         {{-- Vista Collaboratore --}}
                         <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 mb-4">
                             <span class="text-[10px] font-black uppercase text-gray-400 block mb-1">Task
                                 operativo</span>
                             <p class="text-sm font-bold text-gray-900 italic">"{{ $task->title }}"</p>
                         </div>
                         <div>
                             <label
                                 class="block text-[10px] font-black uppercase tracking-widest mb-2 text-blue-600">Aggiorna
                                 Stato</label>
                             <select name="status"
                                 class="block w-full bg-blue-50 border-none rounded-2xl p-4 text-sm font-bold text-blue-600">
                                 <option value="to_do" {{ $task->status == 'to_do' ? 'selected' : '' }}>In attesa
                                 </option>
                                 <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In
                                     corso
                                 </option>
                                 <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>
                                     Completato
                                 </option>
                             </select>
                         </div>
                     @endif
                 </div>
                 <div class="flex items-center justify-end p-6 border-t border-gray-100 gap-3">
                     <button data-modal-hide="edit-task-{{ $task->id }}" type="button"
                         class="px-6 py-3 bg-gray-100 text-gray-500 rounded-2xl font-black uppercase text-[10px] tracking-widest">Annulla</button>
                     <button type="submit"
                         class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-blue-100">Salva
                         Modifiche</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
