@extends('.layouts.master')

@section('component')
    @php
        $user = auth()->user();

        $projectRole = $userRole ?? null;
    @endphp

    <div
        class="h-screen max-h-screen w-full bg-[#f8f9fa] p-4 lg:p-6 overflow-hidden flex flex-col gap-6 font-sans antialiased text-gray-900">

        {{-- header con titolo + modifica ed elimina --}}
        <div
            class="relative shrink-0 overflow-hidden bg-white border border-gray-200 rounded-[2.5rem] p-6 lg:px-10 lg:py-8 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="z-10 flex flex-col md:flex-row items-center gap-4 text-center md:text-left">
                <div class="p-3 bg-blue-50 rounded-2xl">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Progetto e dettagli</span>
                    <h1 class="text-3xl font-black tracking-tighter text-gray-900">
                        {{ strtoupper($project->name) }}
                    </h1>
                </div>
            </div>
            {{-- modifica ed elimina --}}
            <div class="z-10 flex items-center gap-4 bg-gray-50 p-2 rounded-3xl border border-gray-100 shadow-inner">
                {{-- modifica --}}
                @if (auth()->user()->role === 'Admin/PI' || $userProjectRole === 'Project Manager')
                    <button data-modal-target="edit-project-modal" data-modal-toggle="edit-project-modal" type="button"
                        class="h-12 w-12 flex items-center justify-center bg-white rounded-2xl text-emerald-600 shadow-sm hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                @endif
                {{-- elimina --}}
                @if ($user->role === 'Admin/PI')
                    <form action="{{ route('project.destroy', $project->id) }}" method="POST"
                        onsubmit="return confirm('Eliminare l\'intero progetto?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="h-12 w-12 flex items-center justify-center bg-white rounded-2xl text-red-500 shadow-sm hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2.5"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                @endif
            </div>

        </div>

        {{--  team + allegati --}}
        <div class="flex-1 grid grid-cols-1 lg:grid-cols-12 gap-6 min-h-0">

            <div class="lg:col-span-3 flex flex-col gap-6 min-h-0">
                {{-- team --}}
                <section
                    class="flex-1 bg-blue-500 rounded-[2.5rem] p-6 shadow-xl border border-blue-400 flex flex-col min-h-0 text-white">
                    <h3
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60 mb-6 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Team del progetto
                    </h3>
                    <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar-white space-y-3">
                        @foreach ($project->users as $member)
                            <div
                                class="p-4 bg-white/10 rounded-2xl border border-white/10 hover:bg-white hover:text-blue-600 transition-all group">
                                <span
                                    class="block text-[8px] font-black text-white/60 uppercase tracking-tighter group-hover:text-blue-400">{{ $member->pivot->project_role }}</span>
                                <span class="block text-sm font-bold">{{ $member->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- Allegati --}}
                <section class="h-1/2 bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-100 flex flex-col min-h-0">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-4">Allegati</h3>
                    <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-3">
                        @foreach ($project->attachments as $attachment)
                            <div
                                class="group relative bg-gray-50 rounded-2xl p-3 border border-transparent hover:border-blue-100 transition-all">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[10px] font-bold text-gray-800 truncate">{{ $attachment->file_name }}
                                        </p>
                                        <a href="{{ asset('storage/' . $attachment->file_path) }}" download
                                            class="text-[8px] font-black uppercase text-blue-500 hover:text-blue-700">Scarica
                                            file</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            {{-- descrizione + milestone --}}
            <div class="lg:col-span-5 flex flex-col gap-6 min-h-0">

                {{-- MILESTONE --}}
                @include('components.component.milestoneCreateEditDelete')

                {{-- Descrizione --}}
                <section class="h-1/3 bg-blue-500 rounded-[3rem] p-8 shadow-xl text-white relative overflow-hidden">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] mb-4 text-white/60">Descrizione</h3>
                    <div class="overflow-y-auto h-full pb-8 custom-scrollbar-white">
                        <p class="text-sm font-medium leading-relaxed italic">{{ $project->description }}</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                </section>
            </div>

            @include('components.component.taskCreateEditDelete')

            @include('components.component.projectEdit')
        @endsection
