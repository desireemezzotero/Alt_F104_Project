{{-- milestone (CREARE + MODIFICARE + ELIMINARE) --}}
<section class="flex-1 bg-white rounded-[3rem] p-8 shadow-sm border border-gray-100 flex flex-col min-h-0 relative">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-xl font-black tracking-tighter uppercase text-gray-900">Milestoni</h2>
        @if ($isManager)
            <button data-modal-target="create-milestone-modal" data-modal-toggle="create-milestone-modal" type="button"
                class="h-8 w-8 bg-blue-600 text-white rounded-xl flex items-center justify-center hover:scale-110 transition-transform shadow-lg shadow-blue-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        @endif
        {{-- CREARE NUOVO MILESTONE --}}
        <div id="create-milestone-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white border border-gray-200 rounded-[2.5rem] shadow-2xl overflow-hidden">

                    <div class="flex items-center justify-between p-6 border-b border-gray-100">
                        <h3 class="text-xl font-black tracking-tighter uppercase text-gray-900">
                            Nuovo Milestone
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-2xl text-sm w-9 h-9 ms-auto inline-flex justify-center items-center transition-colors"
                            data-modal-hide="create-milestone-modal">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('milestones.store', $project) }}" method="POST">
                        @csrf

                        <div class="p-8 space-y-6">
                            {{-- errori --}}
                            @if ($errors->any())
                                <div
                                    class="p-4 bg-red-50 rounded-2xl border border-red-100 text-red-600 text-xs font-bold">
                                    @foreach ($errors->all() as $error)
                                        <p>• {{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            {{-- titolo --}}
                            <div>
                                <label
                                    class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Titolo
                                    del milestone</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    placeholder="Es. Consegna prototipo"
                                    class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                {{-- stato --}}
                                <div>
                                    <label
                                        class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Stato
                                        Iniziale</label>
                                    <select name="status"
                                        class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all">
                                        <option value="0" selected>In Corso</option>
                                        <option value="1">Già Completata</option>
                                    </select>
                                </div>

                                {{-- data fine --}}
                                <div>
                                    <label
                                        class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Data
                                        Fine Prevista</label>
                                    <input type="date" name="due_date" value="{{ old('due_date') }}" required
                                        min="{{ date('Y-m-d') }}"
                                        class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end p-6 border-t border-gray-100 gap-3">
                            <button data-modal-hide="create-milestone-modal" type="button"
                                class="px-6 py-3 bg-gray-100 text-gray-500 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-gray-200 transition-all">
                                Annulla
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                                Crea Milestone
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD MILESTONE + MODIFICA + ELIMINA --}}
    <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-4">
        @foreach ($project->milestones as $milestone)
            <div
                class="p-5 bg-gray-50 rounded-3xl border border-transparent hover:border-blue-100 hover:bg-white transition-all group">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h4 class="text-base font-black text-gray-900 leading-none mb-2">
                            {{ $milestone->name }}</h4>
                        <div class="flex items-center gap-4">
                            <span class="text-[10px] font-bold text-gray-400 italic">Deadline:
                                {{ \Carbon\Carbon::parse($milestone->due_date)->format('d/m/Y') }}</span>
                            @if ($milestone->status == '0')
                                <span
                                    class="text-[8px] font-black uppercase tracking-widest text-amber-500 px-2 py-0.5 bg-amber-50 rounded-md">In
                                    corso</span>
                            @else
                                <span
                                    class="text-[8px] font-black uppercase tracking-widest text-emerald-500 px-2 py-0.5 bg-emerald-50 rounded-md">Completed</span>
                            @endif
                        </div>
                    </div>

                    {{-- MODIFICA ED ELIMINA --}}
                    @if ($isManager)
                        <div
                            class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">

                            {{-- modifica --}}
                            <button data-modal-target="edit-milestone-{{ $milestone->id }}"
                                data-modal-toggle="edit-milestone-{{ $milestone->id }}" type="button"
                                class="text-blue-600 hover:text-blue-800 flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512">
                                    <path
                                        d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L368 46.1 465.9 144 490.3 119.6c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L432 177.9 334.1 80 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                                </svg>
                            </button>

                            {{-- elimina --}}
                            <form action="{{ route('milestones.destroy', $milestone->id) }}" method="POST"
                                onsubmit="return confirm('Eliminare?')" class="flex items-center">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 flex items-center justify-center">
                                    <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 512">
                                        <path
                                            d="M576 128c0-35.3-28.7-64-64-64L205.3 64c-17 0-33.3 6.7-45.3 18.7L9.4 233.4c-6 6-9.4 14.1-9.4 22.6s3.4 16.6 9.4 22.6L160 429.3c12 12 28.3 18.7 45.3 18.7L512 448c35.3 0 64-28.7 64-64l0-256zM284.1 188.1c9.4-9.4 24.6-9.4 33.9 0l33.9 33.9 33.9-33.9c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-33.9 33.9 33.9 33.9c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-33.9-33.9-33.9 33.9c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l33.9-33.9-33.9-33.9c-9.4-9.4-9.4-24.6 0-33.9z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            {{-- MODIFICA POP UP --}}
            <div id="edit-milestone-{{ $milestone->id }}" data-modal-backdrop="static" tabindex="-1"
                aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white border border-gray-200 rounded-[2.5rem] shadow-2xl overflow-hidden">

                        <div class="flex items-center justify-between p-6 border-b border-gray-100">
                            <h3 class="text-xl font-black tracking-tighter uppercase text-gray-900">
                                Modifica Milestone
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-2xl text-sm w-9 h-9 ms-auto inline-flex justify-center items-center transition-colors"
                                data-modal-hide="edit-milestone-{{ $milestone->id }}">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                </svg>
                            </button>
                        </div>

                        {{-- FORM PER MODIFICARE IL MILESTONE --}}
                        <form action="{{ route('milestones.update', $milestone) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="p-8 space-y-6">
                                {{-- titolo --}}
                                <div>
                                    <label
                                        class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Titolo
                                        della milestone</label>
                                    <input type="text" name="name" value="{{ old('name', $milestone->name) }}"
                                        class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- stato --}}
                                    <div>
                                        <label
                                            class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Stato
                                            Milestone</label>
                                        <select name="status"
                                            class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all">
                                            <option value="0" {{ $milestone->status == 0 ? 'selected' : '' }}>In
                                                Corso
                                                (Pending)
                                            </option>
                                            <option value="1" {{ $milestone->status == 1 ? 'selected' : '' }}>
                                                Completata
                                            </option>
                                        </select>
                                    </div>

                                    {{-- data --}}
                                    <div>
                                        <label
                                            class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Data
                                            Fine Prevista</label>
                                        <input type="date" name="due_date"
                                            value="{{ old('due_date', $milestone->due_date) }}"
                                            class="block w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all">
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end p-6 border-t border-gray-100 gap-3">
                                <button data-modal-hide="edit-milestone-{{ $milestone->id }}" type="button"
                                    class="px-6 py-3 bg-gray-100 text-gray-500 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-gray-200 transition-all">
                                    Annulla
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                                    Salva Modifiche
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
