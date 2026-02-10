<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Publication;
use App\Models\Milestone;
use App\Models\Task;
use App\Models\Attachment;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /* 1. UTENTI STAFF (ADMIN) */
        $admins = collect();
        $admins->push(User::factory()->create([
            'name' => 'Dr. Alessandro Verdi',
            'email' => 'admin@progetto.it',
            'password' => bcrypt('password'),
            'role' => 'Admin/PI'
        ]));

        $admins->push(User::factory()->create([
            'name' => 'Prof. Maria Rossi',
            'email' => 'pi@progetto.it',
            'password' => bcrypt('password'),
            'role' => 'Admin/PI',
        ]));

        /* creazione di 20 ricercatori e 18 collaboratori */
        $researchers = User::factory(25)->create(['role' => 'Researcher',  'password' => bcrypt('password'),]);
        $collaborators = User::factory(22)->create(['role' => 'Collaborator',  'password' => bcrypt('password'),]);

        /* TOTALE UTENTI */
        $allUsers = $admins->merge($researchers)->merge($collaborators);

        /* generazione progetti */
        Project::factory(45)->create()->each(function ($project) use ($allUsers) {

            $isCompleted = ($project->status === 'completed');

            /* creazione per il team */
            $teamSize = rand(4, 10);
            $projectMembers = $allUsers->random($teamSize);

            /* assegnazione dei ruoli */
            foreach ($projectMembers as $index => $user) {
                /*  Il primo della lista è sempre il Project Manager */
                if ($index === 0) {
                    $role = 'Project Manager';
                } else {
                    $role = fake()->randomElement(['Researcher', 'Collaborator']);
                }

                $project->users()->attach($user->id, ['project_role' => $role]);
            }

            /* generazione milestone */
            $numMilestones = rand(3, 5);
            for ($m = 1; $m <= $numMilestones; $m++) {
                $mStatus = $isCompleted ? '1' : fake()->randomElement(['0', '1']);

                $milestone = Milestone::factory()->create([
                    'project_id' => $project->id,
                    'name' => "Fase $m: " . fake()->sentence(3),
                    'status' => $mStatus,
                    'due_date' => Carbon::parse($project->end_date)->subMonths($numMilestones - $m),
                ]);

                /* generazione task per ogni milestone */
                $numTasks = rand(2, 6);
                for ($t = 0; $t < $numTasks; $t++) {
                    $taskStatus = ($isCompleted || $mStatus === '1')
                        ? 'completed'
                        : fake()->randomElement(['to_do', 'in_progress', 'completed']);

                    $task = Task::factory()->create([
                        'project_id' => $project->id,
                        'milestone_id' => $milestone->id,
                        'status' => $taskStatus,
                        'title' => 'Attività: ' . fake()->bs(),
                    ]);

                    /* assegnazione membri  */
                    $taskAssignees = $projectMembers->random(rand(1, 3));
                    $task->users()->attach($taskAssignees->pluck('id'));

                    /* aggiunta commenti solo se il tag della task NON è to_do*/
                    if ($taskStatus !== 'to_do') {
                        for ($c = 0; $c < rand(1, 4); $c++) {
                            Comment::factory()->create([
                                'task_id' => $task->id,
                                'user_id' => $projectMembers->random()->id,
                                'body' => fake()->paragraph(1),
                                'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
                            ]);
                        }
                    }
                }
            }

            /* aggiunta allegati */
            for ($f = 0; $f < rand(1, 3); $f++) {
                $project->attachments()->create([
                    'file_path' => 'file/seed_example.pdf',
                    'file_name' => 'Documento_' . fake()->word() . '.pdf',
                ]);
            }
        });

        /* creazione pubblicazioni*/
        $pubTypes = ['published', 'drafting', 'submitted'];

        foreach (range(1, 30) as $index) {
            $status = fake()->randomElement($pubTypes);
            $publication = Publication::factory()->create([
                'status' => $status,
                'name' => fake()->sentence(8) . ' (Paper ID: ' . rand(1000, 9999) . ')',
            ]);

            /* collegamento delle pubblicazioni ai progetti */
            $linkedProjects = Project::inRandomOrder()->take(rand(1, 2))->pluck('id');
            $publication->projects()->attach($linkedProjects);

            /* autori ad ogni pubblicazione */
            $authors = $allUsers->random(rand(2, 6));
            foreach ($authors as $pos => $author) {
                $publication->authors()->attach($author->id, ['position' => $pos + 1]);
            }

            /* aggiunta allegati, commentata così è null ed appare l'immagine fintane */
            /*  $publication->attachments()->create([
                'file_path' => 'file/manuscript.pdf',
                'file_name' => 'Manuscript_Final_V' . rand(1, 5) . '.pdf',
            ]); */
        }
    }
}
