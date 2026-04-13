<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * GET /api/projects/{projectId}/tasks
     * Listar tarefas do projeto
     */
    public function index(Project $project): JsonResponse
    {
        $tasks = $this->taskService->getProjectTasks($project->id);

        return response()->json([
            'data' => $tasks,
            'message' => 'Tarefas listadas com sucesso',
        ], 200);
    }

    /**
     * POST /api/projects/{projectId}/tasks
     * Criar tarefa
     */
    public function store(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $task = $this->taskService->createTask($project->id, $validated);

        return response()->json([
            'data' => $task,
            'message' => 'Tarefa criada com sucesso',
        ], 201);
    }

    /**
     * GET /api/projects/{projectId}/tasks/{taskId}
     * Obter tarefa específica
     */
    public function show(Project $project, Task $task): JsonResponse
    {
        // Verificar que tarefa pertence ao projeto
        if ($task->project_id !== $project->id) {
            return response()->json([
                'message' => 'Tarefa não encontrada',
            ], 404);
        }

        return response()->json([
            'data' => $task->load('tags'),
            'message' => 'Tarefa obtida com sucesso',
        ], 200);
    }

    /**
     * PUT /api/projects/{projectId}/tasks/{taskId}
     * Atualizar tarefa
     */
    public function update(Request $request, Project $project, Task $task): JsonResponse
    {
        if ($task->project_id !== $project->id) {
            return response()->json([
                'message' => 'Tarefa não encontrada',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $updated = $this->taskService->updateTask($task, $validated);

        return response()->json([
            'data' => $updated,
            'message' => 'Tarefa atualizada com sucesso',
        ], 200);
    }

    /**
     * PATCH /api/projects/{projectId}/tasks/{taskId}/status
     * Atualizar apenas status (atualização parcial)
     */
    public function updateStatus(Request $request, Project $project, Task $task): JsonResponse
    {
        if ($task->project_id !== $project->id) {
            return response()->json([
                'message' => 'Tarefa não encontrada',
            ], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,done',
        ]);

        $updated = $this->taskService->updateTaskStatus($task, $validated['status']);

        return response()->json([
            'data' => $updated,
            'message' => 'Status atualizado com sucesso',
        ], 200);
    }

    /**
     * DELETE /api/projects/{projectId}/tasks/{taskId}
     * Deletar tarefa
     */
    public function destroy(Project $project, Task $task): JsonResponse
    {
        if ($task->project_id !== $project->id) {
            return response()->json([
                'message' => 'Tarefa não encontrada',
            ], 404);
        }

        $this->taskService->deleteTask($task);

        return response()->json([
            'message' => 'Tarefa deletada com sucesso',
        ], 200);
    }

    /**
     * POST /api/tasks/{task}/tags/{tag}
     */
    public function attachTag(Task $task, \App\Models\Tag $tag): JsonResponse
    {
        if ($task->tags()->where('tag_id', $tag->id)->exists()) {
            return response()->json(['message' => 'Tag já associada a esta tarefa'], 422);
        }

        $task->tags()->attach($tag->id);

        return response()->json([
            'data' => $task->load('tags'),
            'message' => 'Tag associada com sucesso',
        ], 200);
    }

    /**
     * DELETE /api/tasks/{task}/tags/{tag}
     */
    public function detachTag(Task $task, \App\Models\Tag $tag): JsonResponse
    {
        $task->tags()->detach($tag->id);

        return response()->json([
            'message' => 'Tag removida com sucesso',
        ], 200);
    }
}