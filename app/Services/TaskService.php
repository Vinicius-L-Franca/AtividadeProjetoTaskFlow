<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Project;

class TaskService
{
    /**
     * Listar tarefas do projeto
     */
    public function getProjectTasks(int $projectId)
    {
        return Task::where('project_id', $projectId)
            ->with('tags')
            ->get();
    }

    /**
     * Criar tarefa
     */
    public function createTask(int $projectId, array $data): Task
    {
        return Task::create([
            'project_id' => $projectId,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'priority' => $data['priority'] ?? 'medium',
            'due_date' => $data['due_date'] ?? null,
        ]);
    }

    /**
     * Atualizar tarefa
     */
    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    /**
     * Atualizar apenas o status
     */
    public function updateTaskStatus(Task $task, string $status): Task
    {
        $task->update(['status' => $status]);
        return $task;
    }

    /**
     * Associar tags à tarefa
     */
    public function attachTags(Task $task, array $tagIds): Task
    {
        $task->tags()->sync($tagIds);
        return $task->fresh()->load('tags');
    }

    /**
     * Deletar tarefa
     */
    public function deleteTask(Task $task): bool
    {
        return $task->delete();
    }
}