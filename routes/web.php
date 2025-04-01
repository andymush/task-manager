<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::resources([
    'tasks' => TaskController::class,
    'projects' => ProjectController::class,
]);

Route::post('/tasks/update-order', [TaskController::class, 'updateOrder'])->name('tasks.update-order');