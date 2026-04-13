# Atividade Projeto TaskFlow API

API REST em Laravel para gerenciamento de projetos, tarefas, tags e perfil de usuario.

## Stack

- PHP 8.4
- Laravel 13
- MySQL (via Docker Compose)
- Swagger UI (L5 Swagger)

## Estrutura principal

- `app/Http/Controllers/Api`: endpoints da API
- `app/Services`: regras de negocio
- `app/Models`: modelos Eloquent
- `database/migrations`: estrutura de banco
- `routes/api.php`: rotas da API
- `app/OpenApi/OpenApi.php`: definicoes OpenAPI

## Como rodar localmente

1. Instalar dependencias PHP:

```bash
composer install
```

2. Criar ambiente:

```bash
cp .env.example .env
php artisan key:generate
```

3. Ajustar credenciais de banco no `.env` (ou usar Docker).

4. Rodar migrations e seed:

```bash
php artisan migrate --seed
```

5. Subir servidor:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## Como rodar com Docker

Na raiz do projeto (um nivel acima de `src`):

```bash
docker compose up --build
```

Servicos principais:

- API: `http://localhost:8000`
- MySQL: porta `3308`

## Swagger UI

Gerar documentacao:

```bash
php artisan l5-swagger:generate
```

Abrir no navegador:

- UI: `http://localhost:8000/api/documentation`
- JSON: `http://localhost:8000/docs`

## Endpoints principais

- `GET /api/projects`
- `POST /api/projects`
- `GET /api/projects/{project}`
- `PUT /api/projects/{project}`
- `DELETE /api/projects/{project}`
- `GET /api/projects/{project}/tasks`
- `POST /api/projects/{project}/tasks`
- `PATCH /api/projects/{project}/tasks/{task}/status`
- `GET /api/tags`
- `POST /api/tags`
- `GET /api/users/{user}/profile`
- `PUT /api/users/{user}/profile`

## Testes

```bash
php artisan test
```

## Ajustes aplicados nesta versao

- Correcao do ambiente de testes para evitar erro de `APP_KEY` ausente.
- Correcao da assinatura dos metodos de associacao de tag em tarefa (`attachTag` e `detachTag`) para bater com as rotas.
- Integracao do Swagger UI com definicoes OpenAPI iniciais.
