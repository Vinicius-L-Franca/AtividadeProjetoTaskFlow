<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'TaskFlow API',
    description: 'Documentacao da API de gerenciamento de projetos, tarefas e tags.'
)]
#[OA\Server(
    url: '/',
    description: 'Servidor local'
)]
#[OA\Tag(name: 'Projects', description: 'Operacoes de projetos')]
#[OA\Tag(name: 'Tags', description: 'Operacoes de tags')]
#[OA\Get(
    path: '/api/projects',
    operationId: 'listProjects',
    tags: ['Projects'],
    summary: 'Lista projetos',
    responses: [
        new OA\Response(
            response: 200,
            description: 'Projetos listados com sucesso',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'message', type: 'string', example: 'Projetos listados com sucesso'),
                    new OA\Property(
                        property: 'data',
                        type: 'array',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'title', type: 'string', example: 'TaskFlow MVP'),
                                new OA\Property(property: 'status', type: 'string', example: 'open'),
                            ],
                            type: 'object'
                        )
                    ),
                ],
                type: 'object'
            )
        )
    ]
)]
#[OA\Post(
    path: '/api/projects',
    operationId: 'createProject',
    tags: ['Projects'],
    summary: 'Cria projeto',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['title'],
            properties: [
                new OA\Property(property: 'title', type: 'string', example: 'Novo Projeto'),
                new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Descricao do projeto'),
                new OA\Property(property: 'deadline', type: 'string', format: 'date', nullable: true, example: '2026-06-30'),
            ],
            type: 'object'
        )
    ),
    responses: [
        new OA\Response(response: 201, description: 'Projeto criado com sucesso'),
        new OA\Response(response: 422, description: 'Erro de validacao')
    ]
)]
#[OA\Get(
    path: '/api/tags',
    operationId: 'listTags',
    tags: ['Tags'],
    summary: 'Lista tags',
    responses: [
        new OA\Response(response: 200, description: 'Tags listadas com sucesso')
    ]
)]
class OpenApi
{
}
