{{-- task --}}
<div class="lg:col-span-4 flex flex-col gap-6 min-h-0">
    <section class="flex-1 bg-white rounded-[3rem] p-8 shadow-sm border border-gray-100 flex flex-col min-h-0">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-xl font-black tracking-tighter uppercase text-gray-900">Task</h2>


            @if ($projectRole)
                <button data-modal-target="create-task-modal" data-modal-toggle="create-task-modal" type="button"
                    class="h-8 w-8 bg-gray-900 text-white rounded-xl flex items-center justify-center hover:scale-110 transition-transform shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            @endif
        </div>

        <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-4">

            @php $activeTasks = $isManager ? $projectWorkflows : $myTasks; @endphp

            {{-- CICLO PER STAMPARE I TASK --}}
            @forelse ($activeTasks as $task)
                <div
                    class="group relative p-5 bg-gray-50 rounded-[2rem] border border-transparent hover:border-blue-200 hover:bg-white transition-all shadow-sm hover:shadow-blue-100">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="text-[8px] font-black uppercase tracking-widest text-blue-500 bg-blue-50 px-2 py-0.5 rounded-md">
                            {{ $task->tag ?? 'Task' }}
                        </span>

                        {{-- COMMENTI + MODIFICA + ELIMINA --}}
                        <div class="flex items-center gap-2">
                            {{-- commenti --}}
                            <button data-drawer-target="drawer-task-{{ $task->id }}"
                                data-drawer-show="drawer-task-{{ $task->id }}" data-drawer-placement="right"
                                type="button"
                                class="h-8 w-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-500 hover:bg-blue-600 hover:text-white transition-all shadow-sm"
                                title="Vedi commenti">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </button>

                            {{-- modifica --}}
                            <button data-modal-target="edit-task-{{ $task->id }}"
                                data-modal-toggle="edit-task-{{ $task->id }}" type="button"
                                class="h-8 w-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>

                            {{-- elimina solo il PM --}}
                            @if ($projectRole)
                                <form action="{{ route('task.destroy', $task->id) }}" method="POST"
                                    onsubmit="return confirm('Vuoi eliminare questo task?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="h-8 w-8 rounded-lg bg-gray-100 flex items-center justify-center text-red-400 hover:bg-red-500 hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <h4 class="text-sm font-black text-gray-900 mb-2 truncate">{{ $task->title }}</h4>

                    {{-- STATO TASK --}}
                    <div class="mt-4">
                        @switch($task->status)
                            @case('to_do')
                                <span class="text-[9px] font-bold text-gray-400 uppercase italic">○ In attesa</span>
                            @break

                            @case('in_progress')
                                <span class="text-[9px] font-bold text-amber-500 uppercase italic animate-pulse">●
                                    Operativo</span>
                            @break

                            @case('completed')
                                <span class="text-[9px] font-bold text-emerald-500 uppercase italic">✔ Concluso</span>
                            @break
                        @endswitch
                    </div>
                </div>

                @include('components.component.formTaskEdit')
                @include('components.component.comments')

                @empty
                    <div class="h-full flex flex-col items-center justify-center text-gray-300 gap-2">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest italic">Nessun Task</span>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
    @include('components.component.formTaskCreate')
