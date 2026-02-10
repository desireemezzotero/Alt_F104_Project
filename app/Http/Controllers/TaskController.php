<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /* fa i controlli generali sull'utente */
    private function checkManagerialPrivileges(Project $project)
    {
        $membership = $project->users()
            ->where('user_id', auth()->id())
            ->first();

        $roleInProject = $membership ? $membership->pivot->project_role : null;

        return auth()->user()->role === 'Admin/PI' || $roleInProject === 'Project Manager';
    }

    /* creare una task */
    public function create(Project $project)
    {
        $project->load(['users', 'milestones']);

        if (!$this->checkManagerialPrivileges($project)) {
            abort(403, 'Privilegi insufficienti per gestire attività in questo progetto.');
        }

        return view('projectShow', [
            'project'        => $project,
            'assignedStaff'  => $project->users,
            'milestones'     => $project->milestones
        ]);
    }

    /* salvataggio della task */
    public function store(Request $request)
    {
        $project = Project::findOrFail($request->project_id);

        if (!$this->checkManagerialPrivileges($project)) {
            abort(403, 'Azione non autorizzata.');
        }

        $validated = $request->validate([
            'project_id'   => 'required|exists:projects,id',
            'milestone_id' => 'required|exists:milestones,id',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'status'       => 'required|in:to_do,in_progress,completed',
            'tag'          => 'required|in:lab,coding,research,writing',
            'user_ids'     => 'required|array',
            /* gli utenti devono appartenere alla tabella pivot del progetto */
            'user_ids.*'   => [
                'exists:users,id',
                Rule::exists('project_user', 'user_id')->where('project_id', $request->project_id)
            ],
        ]);

        $workflow = DB::transaction(function () use ($validated) {
            $task = Task::create(collect($validated)->except('user_ids')->toArray());
            // Sync è più pulito di attach per gestire le relazioni
            $task->users()->sync($validated['user_ids']);
            return $task;
        });

        return redirect()->route('project.show', $project->id)
            ->with('success', 'Nuovo workflow assegnato correttamente.');
    }

    /* visualizzazione della task */
    public function show(Task $task)
    {
        $task->load(['project', 'milestone', 'users', 'comments.user']);
        return view('showTaskPage', compact('task'));
    }

    /* form di modifica */
    public function edit(Task $task)
    {

        $task->load(['project.users', 'project.milestones', 'users']);

        $project = $task->project;

        if (!$this->checkManagerialPrivileges($project)) {
            abort(403, 'Non disponi delle autorizzazioni per modificare questa attività.');
        }

        return view('assignments.edit', [
            'assignment'    => $task,
            'project'       => $project,
            'staff'         => $project->users,
            'milestones'    => $project->milestones,
            'currentUsers'  => $task->users->pluck('id')->toArray()
        ]);
    }

    /* salvataggio delle modifiche della */
    public function update(Request $request, Task $task)
    {
        $isManager = $this->checkManagerialPrivileges($task->project);

        if ($isManager) {

            $rules = [
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'status'      => 'required|in:to_do,in_progress,completed',
                'tag'         => 'required|in:lab,coding,research,writing',
            ];
        } else {

            $rules = ['status' => 'required|in:to_do,in_progress,completed'];
        }

        $task->update($request->validate($rules));

        return back()->with('success', 'Stato dell\'attività aggiornato.');
    }

    /*  eliminazione task */
    public function destroy(Task $task)
    {
        if (!$this->checkManagerialPrivileges($task->project)) {
            abort(403, 'Non puoi eliminare questa attività.');
        }

        $projectId = $task->project_id;

        DB::transaction(function () use ($task) {
            $task->users()->detach();
            $task->delete();
        });

        return redirect()->route('project.show', $projectId)
            ->with('success', 'Attività rimossa dal registro.');
    }



    public function storeComments(Request $request, Task $task)
    {
        $validated = $request->validate([
            'body' => 'required|string|min:1|max:2000',
        ]);

        $task->comments()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Commento aggiunto con successo!');
    }

    public function destroyComments(Comment $comment)
    {
        $project = $comment->task->project;

        if (!$project) {
            abort(404, 'Impossibile trovare il progetto associato a questo task.');
        }

        // Cerchiamo l'utente loggato nel progetto per vedere che ruolo ha
        $member = $project->users()
            ->where('user_id', auth()->id())
            ->first();

        // Ruolo nella pivot del progetto
        $projectRole = $member ? $member->pivot->project_role : null;

        $isAuthorized = (auth()->user()->role === 'Admin/PI') || ($projectRole === 'Project Manager');

        if (!$isAuthorized) {
            abort(403, 'Accesso negato. Solo l\'Admin o il PM del progetto possono eliminare.');
        }

        $comment->delete();

        return back()->with('success', 'Commento eliminato.');
    }
}
