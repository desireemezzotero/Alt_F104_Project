{{-- Progetti --}}
<div class="lg:col-span-6 flex flex-col min-h-0">
    <section class="flex-1 bg-white rounded-[3.5rem] p-8 shadow-sm border border-gray-100 flex flex-col min-h-0">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black tracking-tighter uppercase text-gray-900">Progetti <span
                    class="text-blue-600">Attivi</span></h2>
            <span
                class="h-10 w-10 rounded-full bg-gray-900 flex items-center justify-center text-[10px] font-black text-white shadow-lg shadow-gray-200">
                {{ $projects->count() }}
            </span>
        </div>

        {{-- progetto con titolo e data fine --}}
        <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($projects as $project)
                    <div
                        class="group relative bg-gray-50 rounded-[2.5rem] p-6 border border-transparent hover:border-blue-200 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 overflow-hidden">
                        <div class="flex justify-between items-start mb-10">
                            <div class="flex flex-col">
                                <span
                                    class="text-[8px] font-black uppercase tracking-[0.2em] text-blue-500 mb-1 px-2 py-0.5 bg-blue-50 rounded-md self-start border border-blue-100">
                                    {{ $project->pivot->project_role }}
                                </span>
                                <h4
                                    class="text-xl font-black text-gray-900 leading-none group-hover:text-blue-700 transition-colors mt-2">
                                    {{ $project->name }}</h4>
                            </div>
                        </div>

                        <div class="flex justify-between items-end relative z-10">
                            <div class="space-y-1">
                                <span class="block text-[10px] font-black uppercase text-gray-300 tracking-tighter">data
                                    fine</span>
                                <span
                                    class="block text-xs font-bold text-gray-900 italic">{{ $project->end_date ?? 'N/A' }}</span>
                            </div>

                            <a href="{{ route('project.show', $project->id) }}"
                                class="h-12 w-12 bg-gray-900 rounded-2xl flex items-center justify-center text-white group-hover:bg-blue-600 group-hover:scale-110 transition-all duration-300 shadow-lg shadow-gray-300 group-hover:shadow-blue-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="3" d="M14 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        {{-- sfondo all'hover --}}
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-[5rem] -mr-10 -mt-10 opacity-0 group-hover:opacity-100 transition-all duration-500">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

{{-- progetti gia completati --}}
<div class="lg:col-span-3 flex flex-col gap-6 min-h-0">
    <section
        class="flex-1 bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 flex flex-col min-h-0 relative overflow-hidden">
        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-8">Archivio dei Progetti
            completati
        </h3>
        <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-6">
            @foreach ($completedProjects as $project)
                <div class="border-l-2 border-emerald-400 pl-4 py-1 group cursor-default">
                    <p class="text-xs font-black text-gray-900 mb-1 group-hover:text-emerald-600 transition-colors">
                        {{ $project->name }}</p>
                    <a href="{{ route('project.show', $project->id) }}"
                        class="text-[9px] font-black uppercase text-gray-300 hover:text-gray-900 transition-colors tracking-widest">Review
                        Record</a>
                </div>
            @endforeach
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100">
            <div
                class="flex justify-between items-center bg-emerald-50 p-5 rounded-[2rem] border border-emerald-100 shadow-sm shadow-emerald-100/50">
                <span class="text-[9px] font-black uppercase text-emerald-600 tracking-[0.2em]">Efficiency</span>
                <span class="text-2xl font-black text-emerald-700 tracking-tighter">100%</span>
            </div>
        </div>
    </section>
</div>
