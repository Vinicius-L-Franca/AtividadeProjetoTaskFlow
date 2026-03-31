<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Criar novo usuário com perfil
     */
    public function createUser(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Criar perfil vazio
        $user->profile()->create([]);

        return $user;
    }

    /**
     * Atualizar perfil do usuário
     */
    public function updateProfile(User $user, array $data): User
    {
        $user->profile()->update($data);
        return $user;
    }

    /**
     * Obter usuário com perfil
     */
    public function getUserWithProfile(int $userId): ?User
    {
        return User::with('profile')->find($userId);
    }
}