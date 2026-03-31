<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    private TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * GET /api/tags
     * Listar todas as tags
     */
    public function index(): JsonResponse
    {
        $tags = $this->tagService->getAllTags();

        return response()->json([
            'data' => $tags,
            'message' => 'Tags listadas com sucesso',
        ], 200);
    }

    /**
     * POST /api/tags
     * Criar nova tag
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'color' => 'nullable|string|max:7',
        ]);

        $tag = $this->tagService->createOrGetTag($validated);

        return response()->json([
            'data' => $tag,
            'message' => 'Tag criada com sucesso',
        ], 201);
    }

    /**
     * GET /api/tags/{id}
     * Obter tag específica
     */
    public function show(Tag $tag): JsonResponse
    {
        return response()->json([
            'data' => $tag->load('tasks'),
            'message' => 'Tag obtida com sucesso',
        ], 200);
    }
}