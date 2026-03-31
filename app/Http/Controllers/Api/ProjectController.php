<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    private ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * GET /api/projects
     * Listar projetos do usuário autenticado
     */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id; // Usuário da requisição
        $projects = $this->projectService->getUserProjects($userId);

        return response()->json([
            'data' => $projects,
            'message' => 'Projetos listados com sucesso',
        ], 200);
    }

    /**
     * POST /api/projects
     * Criar novo projeto
     */
    public function store(Request $request): JsonResponse
    {
        // Validar entrada
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        $project = $this->projectService->createProject(
            $request->user()->id,
            $validated
        );

        return response()->json([
            'data' => $project,
            'message' => 'Projeto criado com sucesso',
        ], 201);
    }

    /**
     * GET /api/projects/{id}
     * Obter projeto específico
     */
    public function show(Project $project): JsonResponse
    {
        $projectWithDetails = $this->projectService->getProjectWithDetails($project->id);

        return response()->json([
            'data' => $projectWithDetails,
            'message' => 'Projeto obtido com sucesso',
        ], 200);
    }

    /**
     * PUT /api/projects/{id}
     * Atualizar projeto
     */
    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:open,in_progress,completed',
            'deadline' => 'nullable|date',
        ]);

        $updated = $this->projectService->updateProject($project, $validated);

        return response()->json([
            'data' => $updated,
            'message' => 'Projeto atualizado com sucesso',
        ], 200);
    }

    /**
     * DELETE /api/projects/{id}
     * Deletar projeto
     */
    public function destroy(Project $project): JsonResponse
    {
        $this->projectService->deleteProject($project);

        return response()->json([
            'message' => 'Projeto deletado com sucesso',
        ], 200);
    }
}