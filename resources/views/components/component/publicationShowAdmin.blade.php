  <div id="modal-{{ $publication->id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">

      <div class="relative p-4 w-full max-w-7xl max-h-full">
          <div
              class="relative bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden flex flex-col max-h-[90vh]">

              <div class="flex items-center justify-between p-8 border-b border-gray-50 bg-white z-10">
                  <div class="flex flex-col md:flex-row md:items-center gap-6 flex-1">
                      <div class="flex-1">
                          <span
                              class="inline-block px-3 py-1 bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest rounded-full mb-3">
                              Gestione Pubblicazione
                          </span>
                          <h3 class="text-3xl font-black text-gray-900 tracking-tighter">
                              {{ $publication->name }}
                          </h3>
                      </div>

                      {{-- Actions Rapide --}}
                      <div class="flex items-center gap-2 pr-4">
                          <a href="{{ route('publication.edit', $publication->id) }}"
                              class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-900 transition-all shadow-md">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-width="2.5"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                              </svg>
                              Modifica
                          </a>
                          <form action="{{ route('publication.destroy', $publication->id) }}" method="POST">
                              @csrf @method('DELETE')
                              <button type="submit" onclick="return confirm('Eliminare definitivamente?')"
                                  class="flex items-center justify-center w-[46px] h-[46px] bg-red-50 text-red-500 rounded-xl border border-red-100 hover:bg-red-500 hover:text-white transition-all">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-width="2.5"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                  </svg>
                              </button>
                          </form>
                          <button type="button" data-modal-hide="modal-{{ $publication->id }}"
                              class="ml-4 p-2 text-gray-400 hover:text-gray-900 transition-colors">
                              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                              </svg>
                          </button>
                      </div>
                  </div>
              </div>

              <div class="p-8 overflow-y-auto bg-gray-50/30">
                  <div class="flex flex-col lg:flex-row gap-12">

                      {{-- Colonna Sinistra: Info & Team --}}
                      <div class="lg:w-1/3 space-y-10">
                          <div>
                              <p
                                  class="text-base text-gray-500 font-medium leading-relaxed italic border-l-4 border-blue-200 pl-4 bg-blue-50/30 py-4 rounded-r-2xl">
                                  "{{ $publication->description }}"
                              </p>
                          </div>

                          <div class="space-y-4">
                              <div class="flex items-center justify-between">
                                  <h3 class="text-[10px] font-black uppercase text-gray-400 tracking-widest">
                                      Team Editoriale</h3>
                                  <span
                                      class="px-2 py-0.5 bg-white text-gray-500 text-[9px] font-bold rounded border border-gray-100">
                                      {{ $publication->authors->count() }} Membri
                                  </span>
                              </div>

                              <div class="grid grid-cols-1 gap-2">
                                  @foreach ($publication->authors as $author)
                                      <div
                                          class="flex items-center p-3 bg-white rounded-xl border border-gray-100 shadow-sm transition-all hover:border-blue-200">
                                          <div
                                              class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] font-black">
                                              {{ strtoupper(substr($author->name, 0, 1)) }}
                                          </div>
                                          <div class="ml-3">
                                              <p class="text-xs font-bold text-gray-900 leading-none">
                                                  {{ $author->name }}</p>
                                              <p class="text-[9px] font-medium text-blue-400 uppercase mt-1">
                                                  {{ $author->role }}</p>
                                          </div>
                                      </div>
                                  @endforeach
                              </div>
                          </div>
                      </div>

                      {{-- Colonna Destra: Allegati & Timeline --}}
                      <div class="lg:w-2/3 space-y-10">

                          {{-- Allegati --}}
                          <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
                              <h3 class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-6">
                                  File & Allegati</h3>
                              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                  @forelse ($publication->attachments as $attachment)
                                      <div
                                          class="flex items-center justify-between p-3 bg-gray-50 border border-transparent rounded-xl hover:border-blue-200 transition-all group">
                                          <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank"
                                              class="flex items-center overflow-hidden">
                                              <span
                                                  class="text-blue-600 font-black text-[9px] uppercase mr-3 bg-white px-2 py-1 rounded shadow-sm border border-gray-100">
                                                  {{ pathinfo($attachment->file_path, PATHINFO_EXTENSION) }}
                                              </span>
                                              <span
                                                  class="text-xs font-bold text-gray-700 truncate group-hover:text-blue-600">{{ $attachment->file_name }}</span>
                                          </a>
                                          <form action="{{ route('fileDestroy', $attachment->id) }}" method="POST">
                                              @csrf @method('DELETE')
                                              <button type="submit" onclick="return confirm('Rimuovere allegato?')"
                                                  class="p-1 text-gray-300 hover:text-red-500 transition-colors">
                                                  <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                      viewBox="0 0 24 24">
                                                      <path stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                  </svg>
                                              </button>
                                          </form>
                                      </div>
                                  @empty
                                      <p class="text-xs text-gray-400 italic">Nessun file presente.</p>
                                  @endforelse
                              </div>
                          </div>

                          {{-- Timeline --}}
                          <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm">
                              <div class="flex items-center justify-between mb-8">
                                  <h3 class="text-[10px] font-black uppercase text-gray-400 tracking-widest">
                                      Timeline Progetti</h3>
                                  <a href="{{ route('project.create', ['publication_id' => $publication->id]) }}"
                                      class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg font-black text-[9px] uppercase tracking-widest hover:bg-blue-700 transition-all">
                                      + Aggiungi
                                  </a>
                              </div>

                              <ol class="relative border-s-2 border-blue-50 ml-3">
                                  @forelse ($publication->projects->sortBy('end_date') as $project)
                                      <li class="mb-8 ms-8 group">
                                          <div
                                              class="absolute w-3.5 h-3.5 bg-white border-4 border-blue-600 rounded-full mt-1.5 -start-[8px]">
                                          </div>
                                          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                              <div>
                                                  <time
                                                      class="text-[9px] font-black uppercase tracking-widest {{ \Carbon\Carbon::parse($project->end_date)->isPast() ? 'text-red-400' : 'text-blue-500' }}">
                                                      {{ \Carbon\Carbon::parse($project->end_date)->translatedFormat('d F Y') }}
                                                  </time>
                                                  <h3 class="text-lg font-black text-gray-900 mt-1">
                                                      {{ $project->name }}</h3>
                                              </div>
                                              <div class="flex items-center gap-2">
                                                  <a href="{{ route('project.show', $project->id) }}"
                                                      class="px-4 py-2 bg-gray-50 text-gray-600 border border-gray-100 rounded-lg text-[9px] font-black uppercase hover:bg-blue-600 hover:text-white transition-all">Dettagli</a>
                                              </div>
                                          </div>
                                      </li>
                                  @empty
                                      <p class="text-xs text-gray-400 italic ms-8">Nessun progetto associato.
                                      </p>
                                  @endforelse
                              </ol>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
