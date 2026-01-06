<?php


use Illuminate\Support\Facades\Route;
use App\Models\Organigrama\Controllers\OrgcharController;

Route::prefix('organigrama')->group(function () {
    // Vistas y Lectura de datos
    Route::get('/', [OrgcharController::class, 'index'])->name('organigrama.index');
    Route::get('/hierarchy', [OrgcharController::class, 'returnOrg'])->name('organigrama.create');
    Route::get('/department-colors', [OrgcharController::class, 'returnColors'])->name('organigrama.colors');

    Route::put('/departments/colors', [OrgcharController::class, 'updateColorsDepartment'])->name('organigrama.update-colors');
});

