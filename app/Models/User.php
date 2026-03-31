<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Campos que NÃO devem ser retornados em respostas
    protected $hidden = [
        'password',
    ];

    // Casting de tipos (converte automaticamente)
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relacionamento: Um usuário tem um perfil
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Relacionamento: Um usuário tem muitos projetos
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}