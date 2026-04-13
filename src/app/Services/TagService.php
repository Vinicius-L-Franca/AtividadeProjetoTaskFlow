<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    /**
     * Listar todas as tags
     */
    public function getAllTags()
    {
        return Tag::all();
    }

    /**
     * Criar ou obter tag existente
     */
    public function createOrGetTag(array $data): Tag
    {
        return Tag::firstOrCreate(
            ['name' => $data['name']],
            ['color' => $data['color'] ?? '#808080']
        );
    }

    /**
     * Criar múltiplas tags
     */
    public function createMultipleTags(array $tagsData)
    {
        $tags = [];
        foreach ($tagsData as $tagData) {
            $tags[] = $this->createOrGetTag($tagData);
        }
        return $tags;
    }

    /**
     * Obter tags de uma tarefa
     */
    public function getTaskTags(int $taskId)
    {
        return Tag::whereHas('tasks', function ($query) {
            $query->where('task_id', $taskId);
        })->get();
    }
}