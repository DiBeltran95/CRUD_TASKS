<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\tareaController;

Route::post('/tasks',  [tareaController::class, 'store']);

Route::get('/tasks', [tareaController::class, 'index']);

Route::put('/tasks/{id}', [tareaController::class, 'update']);

Route::delete('/tasks/{id}', [tareaController::class, 'destroy']);