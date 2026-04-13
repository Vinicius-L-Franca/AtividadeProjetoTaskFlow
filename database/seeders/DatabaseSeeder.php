<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Task;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Profile::create([
            'user_id' => $user->id,
            'bio' => 'Desenvolvedor apaixonado por código',
            'phone' => '(41) 99999-0000',
            'avatar_url' => null,
        ]);

        $tag1 = Tag::create(['name' => 'bug',      'color' => '#E24B4A']);
        $tag2 = Tag::create(['name' => 'feature',  'color' => '#1D9E75']);
        $tag3 = Tag::create(['name' => 'melhoria', 'color' => '#378ADD']);

        $project = Project::create([
            'user_id'     => $user->id,
            'title'        => 'TaskFlow MVP',
            'description' => 'Projeto inicial de gerenciamento de tarefas',
            'status'      => 'in_progress',
            'deadline'        => now()->addMonths(2),
        ]);

        $task1 = Task::create([
            'project_id'  => $project->id,
            'title'       => 'Criar migrations',
            'description' => 'Definir todas as tabelas do banco',
            'status'      => 'done',
            'priority'    => 'high',
            'due_date'    => now()->subDays(5),
        ]);

        $task2 = Task::create([
            'project_id'  => $project->id,
            'title'       => 'Implementar services',
            'description' => 'Lógica de negócio nos services',
            'status'      => 'in_progress',
            'priority'    => 'high',
            'due_date'    => now()->addDays(3),
        ]);

        $task1->tags()->attach($tag1->id);
        $task2->tags()->attach([$tag2->id, $tag3->id]);
    }
}