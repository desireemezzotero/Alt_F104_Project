<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicationController extends Controller
{

    /* tutte le pubblicazioni con stato pubblicato */
    public function index()
    {
        $publicationPublished = Publication::with(['authors', 'attachments'])
            ->where('status', 'published')
            ->latest()
            ->get();

        return view('homepage', compact('publicationPublished'));
    }

    /* tutte le pubblicazioni per l'admin */
    public function indexAdmin()
    {
        $stats = [
            'projects' => \App\Models\Project::count(),
            'projects_completed' => \App\Models\Project::where('status', 'completed')->count(),
            'tasks' => \App\Models\Task::count(),
            'tasks_completed' => \App\Models\Task::where('status', 'completed')->count(),
            'users' => \App\Models\User::count(),
            'attachments' => \App\Models\Attachment::count(),
        ];

        $publications = Publication::with(['projects', 'authors'])->latest()->get();
        $projectsList = \App\Models\Project::latest()->get();

        return view('publicationGlobalAdmin', compact('stats', 'projectsList', 'publications'));
    }

    /* nuova pubblicazione */
    public function create()
    {
        if (auth()->user()->role !== 'Admin/PI') abort(403);

        $users = User::all();
        return view('createPublicationAdmin', compact('users'));
    }

    /* salvataggio nuova pubblicazione */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'Admin/PI') abort(403);

        $validated = $this->validateRequest($request);

        return DB::transaction(function () use ($validated, $request) {
            $publication = Publication::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'status' => $validated['status'],
            ]);

            $this->handleRelations($publication, $request, $validated);

            return redirect()->route('publication.show', $publication->id)
                ->with('success', 'Pubblicazione creata con successo!');
        });
    }

    /* visualizzazione di una pubblicazione */
    public function show(Publication $publication)
    {
        $user = auth()->user();
        $relations = ['authors', 'attachments'];

        /* se l'utente è admin vede anche le relazioni con i progetti */
        if ($user && $user->role === 'Admin/PI') {
            $relations[] = 'projects';
        }

        $publication->load($relations);
        return redirect()->route('publication.indexAdmin');
    }

    /* form di modifica di un progetto solo se è admin */
    public function edit(Publication $publication)
    {
        $user = auth()->user();

        if ($user->role !== 'Admin/PI') {
            abort(403);
        }

        $users = User::all();
        $projects = Project::all();
        $currentAuthors = $publication->authors->pluck('id')->toArray();

        return view('publicationEdit', compact('publication', 'users', 'currentAuthors', 'projects'));
    }

    /* salvataggio di modifica di un progetto solo se è admin */
    public function update(Request $request, Publication $publication)
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'Admin/PI';

        if (!$isAdmin) abort(403);
        else {
            $validated = $this->validateRequest($request);

            DB::transaction(function () use ($publication, $validated, $request) {
                $publication->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'status' => $validated['status'],
                ]);

                $this->handleRelations($publication, $request, $validated);
            });
        }

        return redirect()->route('publication.indexAdmin', $publication->id)
            ->with('success', 'Aggiornamento completato!');
    }

    /* eliminazione solo se è admin */
    public function destroy(Publication $publication)
    {
        if (auth()->user()->role !== 'Admin/PI') abort(403);

        $publication->projects()->detach();
        $publication->delete();

        return redirect()->route('publication.indexAdmin')->with('success', 'Pubblicazione eliminata.');
    }



    /* funzioni che vengono richiamate nella rotta update e 
       store per verificare che i dati inseriti siano 
       effettivamente validi
     */

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:drafting,submitted,accepted,published',
            'authors' => 'required|array|min:1',
            'positions' => 'required|array',
            'projects' => 'nullable|array',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,png,docx|max:5120',
        ]);
    }

    private function handleRelations($publication, $request, $validated)
    {

        $syncData = [];
        foreach ($validated['authors'] as $userId) {
            $syncData[$userId] = ['position' => $validated['positions'][$userId] ?? 1];
        }
        $publication->authors()->sync($syncData);


        $publication->projects()->sync($request->input('projects', []));


        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('publications_files', 'public');
                $publication->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }
    }
}
