<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Attachment;
use App\Models\Comment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        /* ADMIN */
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
                // Carico solo i dati necessari per le liste recenti
                'recentAttachments' => Attachment::with('attachable')->latest()->take(8)->get(),
                'recentComments'    => Comment::with(['user', 'task.project'])->latest()->take(8)->get(),
            ]);
        }


        $activeProjects    = $user->projects()->whereIn('projects.status', ['on_hold', 'active'])->get();
        $completedProjects = $user->projects()->where('projects.status', 'completed')->get();

        /* scadenze entro 7 giorni */
        $upcomingDeadlines = $user->projects()
            ->whereBetween('end_date', [now(), now()->addDays(7)])
            ->get();

        /* calcolo percentuale */
        $totalTasks     = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('status', 'completed')->count();
        $progressPercentageTasks = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        $publicationCount = $user->publications()->whereIn('status', ['submitted', 'drafting'])->get();

        return view('dashboard', compact(
            'user',
            'activeProjects',
            'completedProjects',
            'upcomingDeadlines',
            'progressPercentageTasks',
            'publicationCount'
        ));
    }
}
