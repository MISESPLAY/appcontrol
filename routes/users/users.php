<?php

use Illuminate\Support\Facades\Route;
use App\Models\UserManagement\Controller\UserController; // Asegúrate que este namespace sea correcto

Route::prefix('users')->group(function () {
    route::get('',[UserController::class, 'viewUsers']) -> name('users');
    route::get('/data',[UserController::class, 'DataUsers']) -> name('data-users');
    // Ejemplo de rutas para tu futuro CRUD
    // Route::get('/', [UserController::class, 'index'])->name('users.index');
    // Route::post('/create', [UserController::class, 'store'])->name('users.store');
});
