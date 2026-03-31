<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * GET /api/users/{id}/profile
     * Obter perfil do usuário
     */
    public function show(Request $request): JsonResponse
    {
        $user = $this->userService->getUserWithProfile($request->user()->id);

        return response()->json([
            'data' => $user,
            'message' => 'Perfil obtido com sucesso',
        ], 200);
    }

    /**
     * PUT /api/users/{id}/profile
     * Atualizar perfil do usuário
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'bio' => 'nullable|string',
            'phone' => 'nullable|string',
            'avatar_url' => 'nullable|url',
        ]);

        $user = $this->userService->updateProfile($request->user(), $validated);

        return response()->json([
            'data' => $user,
            'message' => 'Perfil atualizado com sucesso',
        ], 200);
    }
}