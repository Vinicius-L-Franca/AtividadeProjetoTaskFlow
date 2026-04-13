<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function show(User $user): JsonResponse
    {
        $result = $this->userService->getUserWithProfile($user->id);

        return response()->json([
            'data' => $result,
            'message' => 'Perfil obtido com sucesso',
        ], 200);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'bio' => 'nullable|string',
            'phone' => 'nullable|string',
            'avatar_url' => 'nullable|url',
        ]);

        $result = $this->userService->updateProfile($user, $validated);

        return response()->json([
            'data' => $result,
            'message' => 'Perfil atualizado com sucesso',
        ], 200);
    }
}