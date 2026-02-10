<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Verifica se l'utente è Admin o Project Manager del progetto specifico.
     */
    private function isAuthorized(Project $project)
    {
        $user = auth()->user();
        if ($user->role === 'Admin/PI') return true;

        return $project->users()
            ->where('user_id', $user->id)
            ->wherePivot('project_role', 'Project Manager')
            ->exists();
    }

    /* visualizzazione progetti */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->role === 'Admin/PI') {
            return view('dashboardAdmin', [
                'stats' => [
                    'projects'           => Project::count(),
                    'projects_completed' => Project::where('status', 'completed')->count(),
                    'tasks'              => Task::count(),
                    'tasks_completed'    => Task::where('status', 'completed')->count(),
                    'users'              => User::count(),
                    'attachments'        => Attachment::count(),
                ],
                'recentAttachments' => Attachment::with(['attachable'])->latest()->take(8)->get(),
                'recentComments'    => Comment::with(['user', 'task.project'])->latest()->take(8)->get(),
            ]);
        }

        // Dashboard Utente/Ricercatore
        $userProjects = $user->projects()->with('tasks');

        $projects          = (clone $userProjects)->whereIn('projects.status', ['on_hold', 'active'])->get();
        $completedProjects = (clone $userProjects)->where('projects.status', 'completed')->get();

        $criticalAlerts = $user->projects()
            ->whereBetween('end_date', [now(), now()->addDays(7)])
            ->get();

        $totalTasks     = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('status', 'completed')->count();
        $operationalFlow = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        $manuscripts = $user->publications()->whereIn('status', ['submitted', 'drafting'])->get();

        return view('dashboard', compact(
            'user',
            'projects',
            'completedProjects',
            'criticalAlerts',
            'operationalFlow',
            'manuscripts'
        ));
    }

    /* creare progetti */
    public function create(Request $request)
    {
        return view('projectCreate', [
            'publicationId' => $request->query('publication_id'),
            'users'         => User::all()
        ]);
    }

    /* salvare progetti */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'Admin/PI') abort(403);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'end_date'       => 'nullable|date',
            'status'         => 'required|in:active,on_hold,completed',
            'publication_id' => 'nullable|exists:publications,id',
            'users'          => 'required|array|min:2',
            'users.*'        => 'exists:users,id',
            'project_roles'  => 'required|array',
            'attachments.*'  => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $project = Project::create([
                'name'        => $validated['name'],
                'description' => $validated['description'],
                'status'      => $validated['status'],
                'end_date'    => $validated['end_date'],
            ]);

            // Sync Team con Ruoli
            $syncData = [];
            foreach ($validated['users'] as $userId) {
                $syncData[$userId] = ['project_role' => $request->project_roles[$userId] ?? 'Member'];
            }
            $project->users()->attach($syncData);

            if ($validated['publication_id']) {
                $project->publications()->attach($validated['publication_id']);
            }

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $project->attachments()->create([
                        'file_path' => $file->store('file', 'public'),
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            return $validated['publication_id']
                ? redirect()->route('publication.show', $validated['publication_id'])->with('success', 'Progetto creato.')
                : redirect()->route('dashboard')->with('success', 'Progetto creato.');
        });
    }

    /* visualizzare il progetto */
    public function show(Project $project)
    {
        $user = auth()->user();
        $project->load(['users', 'tasks.users', 'milestones', 'attachments']);

        $member = $project->users->where('id', $user->id)->first();
        $userProjectRole = $member ? $member->pivot->project_role : null;
        $isManager = $user->role === 'Admin/PI' || $userProjectRole === 'Project Manager';

        return view('projectShow', [
            'project'          => $project,
            'myTasks'          => $project->tasks->filter(fn($t) => $t->users->contains($user->id)),
            'projectWorkflows' => $project->tasks,
            'isManager'        => $isManager,
            'userProjectRole'  => $userProjectRole
        ]);
    }

    /* form modifica il progetto */
    public function edit(Project $project)
    {
        if (!$this->isAuthorized($project)) abort(403);

        $project->load('attachments');
        $projectRole = $project->users()->where('user_id', auth()->id())->first()?->pivot->project_role;

        return view('projectShow', compact('project', 'projectRole'));
    }

    /* salvataggio modifiche del progetto */
    public function update(Request $request, Project $project)
    {
        if (!$this->isAuthorized($project)) abort(403);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'status'        => 'required|in:active,on_hold,completed',
            'end_date'      => 'nullable|date',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $project->update($validated);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $project->attachments()->create([
                    'file_path' => $file->store('file', 'public'),
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        $publication = $project->publications()->first();
        if (auth()->user()->role === 'Admin/PI' && $publication) {
            return redirect()->route('publication.show', $publication->id)->with('success', 'Aggiornato.');
        }

        return redirect()->route('project.show', $project->id)->with('success', 'Progetto aggiornato.');
    }

    /* elimina progetto */
    public function destroy(Project $project)
    {
        if (!$this->isAuthorized($project)) abort(403);

        $publicationId = $project->publications()->first()?->id;

        foreach ($project->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        DB::transaction(function () use ($project) {
            $project->users()->detach();
            $project->publications()->detach();
            $project->attachments()->delete();
            $project->delete();
        });

        return auth()->user()->role === 'Admin/PI' && $publicationId
            ? redirect()->route('publication.show', $publicationId)->with('success', 'Eliminato.')
            : redirect()->route('dashboard')->with('success', 'Eliminato.');
    }

    /* elimina allegati */
    public function fileDestroy(Attachment $attachment)
    {
        $user  = auth()->user();
        $owner = $attachment->attachable;

        if ($user->role !== 'Admin/PI') {
            if ($attachment->attachable_type === Project::class) {
                if (!$this->isAuthorized($owner)) abort(403);
            } else {
                abort(403);
            }
        }

        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return ($attachment->attachable_type === Project::class)
            ? redirect()->route('project.show', $owner->id)->with('success', 'Allegato rimosso.')
            : redirect()->route('publication.edit', $owner->id)->with('success', 'Allegato rimosso.');
    }
}
