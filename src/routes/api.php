<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\ProfileController;

// Tags
Route::get('/tags', [TagController::class, 'index']);
Route::post('/tags', [TagController::class, 'store']);
Route::get('/tags/{tag}', [TagController::class, 'show']);

// Projects
Route::get('/projects', [ProjectController::class, 'index']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::put('/projects/{project}', [ProjectController::class, 'update']);
Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);

// Tasks
Route::get('/projects/{project}/tasks', [TaskController::class, 'index']);
Route::post('/projects/{project}/tasks', [TaskController::class, 'store']);
Route::get('/projects/{project}/tasks/{task}', [TaskController::class, 'show']);
Route::put('/projects/{project}/tasks/{task}', [TaskController::class, 'update']);
Route::patch('/projects/{project}/tasks/{task}/status', [TaskController::class, 'updateStatus']);
Route::delete('/projects/{project}/tasks/{task}', [TaskController::class, 'destroy']);

// Tag-Task
Route::post('/tasks/{task}/tags/{tag}', [TaskController::class, 'attachTag']);
Route::delete('/tasks/{task}/tags/{tag}', [TaskController::class, 'detachTag']);

// Profile
Route::get('/users/{user}/profile', [ProfileController::class, 'show']);
Route::put('/users/{user}/profile', [ProfileController::class, 'update']);