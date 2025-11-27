<?php

namespace App\Models\Login\controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function index()
    {
        return view('Login.loginUser'); // Carga resources/views/Login/loginUser.blade.php
    }

    /**
     * Procesar la autenticación
     */
    public function authenticate(Request $request)
    {
        // Aquí pondrás la lógica de autenticación
        return "Procesando login";
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        return "Cerrando sesión";
    }
}
