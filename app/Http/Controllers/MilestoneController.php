<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Project;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    /* creare la milestone */
    public function create(Project $project)
    {
        return view('createMilestonePage', compact('project'));
    }

    /* salvare la milestone */
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            // Aggiunto: deve essere oggi o una data futura
            'due_date' => 'required|date|after_or_equal:today',
            'status'   => 'required|boolean',
        ], [
            // Messaggio personalizzato per la regola after_or_equal
            'due_date.after_or_equal' => 'La data della milestone non può essere nel passato.',
        ]);

        $project->milestones()->create($validated);

        return redirect()->route('project.show', $project)
            ->with('success', 'Nuova milestone aggiunta con successo!');
    }

    /* modificare la milestone */
    public function edit(Milestone $milestone)
    {
        return view('editMilestonePage', compact('milestone'));
    }

    /* salvare la milestone modificata */
    public function update(Request $request, Milestone $milestone)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            // Aggiunto anche qui per la modifica
            'due_date' => 'required|date|after_or_equal:today',
            'status'   => 'required|boolean',
        ], [
            'due_date.after_or_equal' => 'La data della milestone non può essere nel passato.',
        ]);

        $milestone->update($validated);

        return redirect()->route('project.show', $milestone->project_id)
            ->with('success', 'Milestone aggiornata!');
    }

    /* eliminarla */
    public function destroy(Milestone $milestone)
    {
        $projectId = $milestone->project_id;
        $milestone->delete();

        return redirect()
            ->route('project.show', $projectId)
            ->with('success', 'Milestone eliminata definitivamente.');
    }
}
