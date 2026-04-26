<?php

use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tareas');

Route::get('/', function () {
    return view('welcome');
    
});

Route::patch('/tareas/{tarea}/toggle', [TareaController::class, 'toggle'])->name('tareas.toggle');
Route::resource('tareas', TareaController::class)->except(['show']);
