<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) return redirect()->route('login');

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Admin/PI passa sempre
        if ($user->role === 'Admin/PI') return $next($request);

        // 2. Recupero del progetto (a cascata)
        $project = $request->route('project');

        // Se è un ID numerico, lo trasformiamo in oggetto
        if (is_numeric($project)) {
            $project = \App\Models\Project::find($project);
        }

        // Se non c'è, proviamo dalla Milestone
        if (!$project && $request->route('milestone')) {
            $milestone = $request->route('milestone');
            $project = is_numeric($milestone) ? \App\Models\Milestone::find($milestone)?->project : $milestone->project;
        }

        // Se non c'è, proviamo dal Task
        if (!$project && $request->route('task')) {
            $task = $request->route('task');
            $project = is_numeric($task) ? \App\Models\Task::find($task)?->project : $task->project;
        }

        // --- AGGIUNTA PER I COMMENTI ---
        if (!$project && $request->route('comment')) {
            $comment = $request->route('comment');
            // Risaliamo: Comment -> Task -> Project
            $commentObj = is_numeric($comment) ? \App\Models\Comment::find($comment) : $comment;
            $project = $commentObj?->task?->project;
        }

        // 3. Verifica finale sulla tabella Pivot
        if ($project instanceof \App\Models\Project) {
            $isProjectManager = $user->projects()
                ->where('projects.id', $project->id)
                ->wherePivot('project_role', 'Project Manager')
                ->exists();

            if ($isProjectManager) {
                return $next($request);
            }
        }

        return abort(403, 'Azione negata: non sei il Project Manager di questo progetto.');
    }
}
