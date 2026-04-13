<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;

class ProjectService
{
    /**
     * Listar projetos do usuário
     */
    public function getUserProjects(int $userId)
    {
        return Project::where('user_id', $userId)
            ->withCount('tasks')
            ->get();
    }

    /**
     * Criar projeto
     */
    public function createProject(int $userId, array $data): Project
    {
        return Project::create([
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'open',
            'deadline' => $data['deadline'] ?? null,
        ]);
    }

    /**
     * Atualizar projeto
     */
    public function updateProject(Project $project, array $data): Project
    {
        $project->update($data);
        return $project;
    }

    /**
     * Deletar projeto e suas tarefas
     */
    public function deleteProject(Project $project): bool
    {
        // cascade delete remove automaticamente as tarefas
        return $project->delete();
    }

    /**
     * Obter projeto com todas as informações
     */
    public function getProjectWithDetails(int $projectId): ?Project
    {
        return Project::with(['tasks.tags', 'user'])->find($projectId);
    }
}