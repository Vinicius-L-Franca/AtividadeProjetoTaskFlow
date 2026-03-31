<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relacionamento: Um projeto pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento: Um projeto tem muitas tarefas
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}