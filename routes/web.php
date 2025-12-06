<?php

use Illuminate\Support\Facades\Route;
use App\Models\Organigrama\Controllers\OrgcharController;

route::prefix('organigrama')->group(function () {
    Route::get('/', [OrgcharController::class, 'index'])->name('organigrama.index');
    route::get('/hierarchy', [OrgcharController::class, 'returnOrg'])->name('organigrama.create');


});


