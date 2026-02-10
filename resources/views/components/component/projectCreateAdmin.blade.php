    <form id="project-form" action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data"
        class="space-y-8">
        @csrf
        <input type="hidden" name="publication_id" value="{{ $publicationId }}">

        {{-- titolo + descrizione --}}
        <div class=" p-10 rounded-3xl border border-gray-100 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

                {{-- titolo --}}
                <div class="relative z-0 w-full group">
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="block h-[46px] py-3 px-0 w-full text-xl text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer font-bold"
                        placeholder=" " required />
                    <label for="name"
                        class="absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase font-black tracking-wider">
                        Nome Progetto
                    </label>
                </div>

                {{-- descrizione --}}
                <div class="relative z-0 w-full group">
                    <textarea name="description" id="description" rows="1"
                        class="block py-3 px-0 w-full text-sm text-gray-700 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer resize-none leading-relaxed min-h-[46px]"
                        placeholder=" " required>{{ old('description') }}</textarea>
                    <label for="description"
                        class="absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase font-black tracking-wider">
                        Descrizione
                    </label>
                </div>

            </div>
        </div>

        {{-- data fine --}}
        <div class=" rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden p-8">
            <div class="mb-6 flex justify-between items-center">

                <h2 class="text-xl font-black text-gray-900 tracking-tight">Fine
                    <span class="text-blue-600">
                        Progetto
                    </span>
                </h2>

                <div class="p-3 bg-blue-50 rounded-2xl">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <div class="space-y-4">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Giorno
                    di scadenza</label>

                <div class="relative group">
                    <input type="date" name="end_date" value="{{ old('end_date', now()->format('Y-m-d')) }}"
                        class="block w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-5 text-blue-600 font-black text-sm focus:border-blue-600 focus:ring-0 transition-all appearance-none outline-none cursor-pointer">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        {{-- stato + allegati --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- stato --}}
            <div class=" p-8 rounded-3xl border border-gray-100 shadow-sm">
                <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-6">Stato
                    Progetto</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach (['active' => '✅ Attivo', 'on_hold' => '⏳ Pausa', 'completed' => '🏆 Fine'] as $val => $label)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="{{ $val }}" class="peer hidden"
                                {{ old('status', 'active') == $val ? 'checked' : '' }}>
                            <div
                                class="text-center p-3 rounded-2xl border border-gray-100 bg-gray-50 text-[11px] font-black uppercase text-gray-500 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition-all">
                                {{ $label }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- allegati --}}
            <div class="p-8 rounded-3xl border border-gray-100 shadow-sm">
                <label class="block text-xs font-black uppercase text-gray-400 tracking-[0.2em] mb-4">Allegati</label>
                <input type="file" name="attachments[]" multiple
                    class="block w-full text-xs text-gray-400 file:mr-4 file:py-2.5 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 transition-all cursor-pointer">
            </div>
        </div>

        {{-- utenti --}}
        <div class=" rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <label class="text-xs font-black uppercase text-gray-400 tracking-[0.2em]">Gestione Team e
                    ruoli</label>
                <span class="text-[10px] bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-bold uppercase">
                    Minimo 2 utenti
                </span>
            </div>

            {{-- tabella utenti --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase">Utente</th>
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase">Ruolo Applicazione
                            </th>
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase">Ruolo Progetto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($users as $user)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-4">
                                        <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                            id="u{{ $user->id }}"
                                            class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500/20 transition cursor-pointer">
                                        <label for="u{{ $user->id }}"
                                            class="text-sm font-bold text-gray-700 cursor-pointer">{{ $user->name }}</label>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="text-xs text-gray-400 font-medium italic">{{ $user->role }}</span>
                                </td>
                                <td class="px-8 py-4">
                                    <select name="project_roles[{{ $user->id }}]"
                                        class="text-xs font-bold border-gray-100 bg-gray-50 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                                        <option value="Researcher">Ricercatore</option>
                                        <option value="Project Manager">Project Manager</option>
                                        <option value="Collaborator">Collaboratore</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </form>
