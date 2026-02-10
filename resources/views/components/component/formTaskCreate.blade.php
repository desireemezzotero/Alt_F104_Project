 {{-- Form per creare la task --}}
 @if ($isManager)
     <div id="create-task-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
         <div class="relative p-4 w-full max-w-2xl max-h-full">
             <div class="relative bg-white border border-gray-200 rounded-[2.5rem] shadow-2xl overflow-hidden text-left">

                 <div class="flex items-center justify-between p-6 border-b border-gray-100">
                     <h3 class="text-xl font-black tracking-tighter uppercase text-gray-900">Nuovo Task</h3>
                     <button type="button" data-modal-hide="create-task-modal"
                         class="text-gray-400 hover:bg-gray-100 rounded-2xl w-9 h-9 flex justify-center items-center transition-colors">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                         </svg>
                     </button>
                 </div>

                 <form action="{{ route('project.task.store', $project->id) }}" method="POST">
                     @csrf
                     {{-- Campo nascosto per il project_id richiesto dal tuo controller --}}
                     <input type="hidden" name="project_id" value="{{ $project->id }}">

                     <div class="p-8 space-y-5">
                         {{-- Titolo --}}
                         <div>
                             <label
                                 class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Titolo
                                 Task</label>
                             <input type="text" name="title" required placeholder="Cosa bisogna fare?"
                                 class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all">
                         </div>

                         {{-- Selezione Milestone --}}
                         <div>
                             <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                                 Milestone di riferimento
                             </label>
                             <select name="milestone_id" required
                                 class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500">
                                 <option value="" disabled selected>Seleziona una milestone...</option>
                                 {{-- CAMBIATO QUI: da $milestones a $project->milestones --}}
                                 @foreach ($project->milestones as $milestone)
                                     <option value="{{ $milestone->id }}">{{ $milestone->name }}</option>
                                 @endforeach
                             </select>
                         </div>

                         {{-- Assegnazione Utenti (Multipla) --}}
                         <div>
                             <label
                                 class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Assegna
                                 a (Team)</label>
                             <div
                                 class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto p-2 bg-gray-50 rounded-2xl custom-scrollbar">
                                 @foreach ($project->users as $u)
                                     <label
                                         class="flex items-center space-x-3 p-2 hover:bg-white rounded-xl cursor-pointer transition-all">
                                         <input type="checkbox" name="user_ids[]" value="{{ $u->id }}"
                                             class="rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                                         <span class="text-xs font-bold text-gray-700">{{ $u->name }}</span>
                                     </label>
                                 @endforeach
                             </div>
                         </div>

                         <div class="grid grid-cols-2 gap-4">
                             {{-- Tag --}}
                             <div>
                                 <label
                                     class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Tag</label>
                                 <select name="tag" required
                                     class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500">
                                     <option value="lab">Laboratorio</option>
                                     <option value="coding">Sviluppo software</option>
                                     <option value="research">Ricerca</option>
                                     <option value="writing">Documentazione</option>
                                 </select>
                             </div>
                             {{-- Stato --}}
                             <div>
                                 <label
                                     class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Stato
                                     Iniziale</label>
                                 <select name="status" required
                                     class="block w-full bg-blue-50 border-none rounded-2xl p-4 text-sm font-bold text-blue-600 focus:ring-2 focus:ring-blue-500">
                                     <option value="to_do">In attesa</option>
                                     <option value="in_progress">In corso</option>
                                 </select>
                             </div>
                         </div>

                         {{-- Descrizione --}}
                         <div>
                             <label
                                 class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Descrizione</label>
                             <textarea name="description" rows="2" placeholder="Dettagli aggiuntivi..."
                                 class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 transition-all"></textarea>
                         </div>
                     </div>

                     <div class="flex items-center justify-end p-6 border-t border-gray-100 gap-3">
                         <button data-modal-hide="create-task-modal" type="button"
                             class="px-6 py-3 bg-gray-100 text-gray-500 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-gray-200 transition-all">
                             Annulla
                         </button>
                         <button type="submit"
                             class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                             Crea Task
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 @endif
