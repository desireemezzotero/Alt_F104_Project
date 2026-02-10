<div id="drawer-task-{{ $task->id }}"
    class="fixed top-0 right-0 z-40 h-screen p-6 overflow-y-auto transition-transform translate-x-full bg-white w-80 lg:w-96 shadow-2xl border-l border-gray-100"
    tabindex="-1">
    <div class="flex items-center justify-between mb-6">
        <h5 class="text-sm font-black uppercase tracking-widest text-gray-500 italic">Dettaglio Task
        </h5>
        <button type="button" data-drawer-hide="drawer-task-{{ $task->id }}"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    <div class="space-y-6">
        {{-- TITOLO + DESCRIZIONE --}}
        <div>
            <h3 class="text-lg font-black text-gray-900 mb-2">{{ $task->title }}</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                {{ $task->description ?? 'Nessuna descrizione fornita per questo task.' }}
            </p>
        </div>

        <hr class="border-gray-100">

        {{-- COMMENTI --}}
        <div class="mt-8">
            <h5 class="text-xs font-black text-gray-400 uppercase mb-4 flex items-center tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                Commenti ({{ $task->comments->count() }})
            </h5>

            {{-- COMMENTI + ELIMINAZIONE COMMENTO --}}
            <div class="space-y-4 mb-8 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                @forelse ($task->comments as $comment)
                    <div
                        class="bg-gray-50 rounded-2xl p-4 border border-gray-100 flex justify-between items-start group shadow-sm">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[11px] font-black text-gray-900 uppercase tracking-tighter">
                                    {{ $comment->user->name }}
                                </span>
                                <span class="text-[10px] text-gray-400 italic">
                                    • {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                {{ $comment->body }}
                            </p>
                        </div>

                        {{-- eliminare il commento --}}
                        <div class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <form action="{{ route('destroyComments', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Vuoi eliminare questo commento?')"
                                    class="h-7 w-7 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 border-2 border-dashed border-gray-100 rounded-[2rem]">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Nessun commento</p>
                    </div>
                @endforelse
            </div>

            {{-- aggiunta commento --}}
            <div class="bg-gray-900 p-6 rounded-[2.5rem] shadow-xl">
                <form action="{{ route('comments.store', $task->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="relative">
                        <label
                            class="text-[9px] font-black text-blue-400 uppercase tracking-[0.2em] ml-2 mb-2 block">Scrivi
                            un messaggio</label>
                        <textarea name="body" rows="3" required placeholder="Ehy, a che punto siamo?..."
                            class="block w-full rounded-2xl border-transparent bg-gray-800 text-white shadow-inner focus:ring-2 focus:ring-blue-500 text-xs transition-all resize-none p-4 placeholder-gray-500"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-6 py-3.5 bg-blue-600 border border-transparent rounded-xl font-black text-[10px] text-white uppercase tracking-widest hover:bg-blue-500 active:scale-95 transition-all shadow-lg shadow-blue-900/40">
                        <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Invia Commento
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
