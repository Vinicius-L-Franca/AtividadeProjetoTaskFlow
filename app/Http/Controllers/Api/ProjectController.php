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

    public function index(): JsonResponse
    {
        $projects = $this->projectService->getUserProjects(1);

        return response()->json([
            'data' => $projects,
            'message' => 'Projetos listados com sucesso',
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        $project = $this->projectService->createProject(1, $validated);

        return response()->json([
            'data' => $project,
            'message' => 'Projeto criado com sucesso',
        ], 201);
    }

    public function show(Project $project): JsonResponse
    {
        $projectWithDetails = $this->projectService->getProjectWithDetails($project->id);

        return response()->json([
            'data' => $projectWithDetails,
            'message' => 'Projeto obtido com sucesso',
        ], 200);
    }

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

    public function destroy(Project $project): JsonResponse
    {
        $this->projectService->deleteProject($project);

        return response()->json([
            'message' => 'Projeto deletado com sucesso',
        ], 200);
    }
}