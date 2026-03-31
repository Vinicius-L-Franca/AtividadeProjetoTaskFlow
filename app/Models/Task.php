<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relacionamento: Uma tarefa pertence a um projeto
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relacionamento muitos-para-muitos: Uma tarefa tem muitas tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}