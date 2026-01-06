<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (El HUB Principal)
|--------------------------------------------------------------------------
| Aquí defines las validaciones generales (como 'auth') y cargas los módulos.
*/

Route::get('/', function () {
    return view('welcome');
});

// Agrupamos los módulos bajo el middleware 'web' (y 'auth' si requieres login)
Route::middleware(['web'])->group(function () {

    // --- MODULO 1: ORGANIGRAMA ---
    // Carga las rutas desde: C:\laravel\APPS_PROYECT\routes\OrgChart\orgchart.php
    require base_path('routes/OrgChart/orgchart.php');

    // --- MODULO 2: USUARIOS ---
    // Carga las rutas desde: C:\laravel\APPS_PROYECT\routes\Users\users.php
    require base_path('routes/Users/users.php');

});
