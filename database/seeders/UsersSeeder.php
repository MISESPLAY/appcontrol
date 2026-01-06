<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Asegúrate de importar tu Modelo User correcto
// use App\Models\Users\Persistence\Eloquent\Models\UserModel; // O usa tu ruta personalizada si la cambiaste

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiamos la tabla primero para evitar duplicados si lo corres dos veces
        // User::truncate(); // Descomenta esto si quieres borrar todo antes de crear

        $password = Hash::make('password'); // Contraseña genérica para todos

        // ==========================================
        // NIVEL 1: EL CEO (No tiene jefe)
        // ==========================================
        $ceo = User::create([
            'name'           => 'Director General',
            'username'       => 'ceo_admin',
            'FirstName'      => 'Carlos',
            'LastName'       => 'Slim',
            'email'          => 'ceo@empresa.com',
            'password'       => $password,
            'department_id'  => 1, // Asumiendo que 1 es Dirección
            'reports_to_id'  => null, // ES LA RAÍZ
            'reports_to'     => null,
        ]);

        // ==========================================
        // NIVEL 2: GERENTES (Reportan al CEO)
        // ==========================================

        // Gerente de Marketing
        $headMarketing = User::create([
            'name'           => 'Gerente Marketing',
            'username'       => 'gerente_mkt',
            'FirstName'      => 'Sofía',
            'LastName'       => 'Vergara',
            'email'          => 'sofia@empresa.com',
            'password'       => $password,
            'department_id'  => 2, // Asumiendo que 2 es Marketing
            'reports_to_id'  => $ceo->id, // Reporta al CEO
            'reports_to'     => $ceo->FirstName . ' ' . $ceo->LastName,
        ]);

        // Gerente de IT (Software)
        $headIT = User::create([
            'name'           => 'Gerente TI',
            'username'       => 'gerente_it',
            'FirstName'      => 'Bill',
            'LastName'       => 'Gates',
            'email'          => 'bill@empresa.com',
            'password'       => $password,
            'department_id'  => 3, // Asumiendo que 3 es Software
            'reports_to_id'  => $ceo->id, // Reporta al CEO
            'reports_to'     => $ceo->FirstName . ' ' . $ceo->LastName,
        ]);

        // ==========================================
        // NIVEL 3: EMPLEADOS (Reportan a los Gerentes)
        // ==========================================

        // Empleado de Marketing (Reporta a Sofía)
        User::create([
            'name'           => 'Diseñador Sr',
            'username'       => 'disenador_1',
            'FirstName'      => 'Picasso',
            'LastName'       => 'Junior',
            'email'          => 'picasso@empresa.com',
            'password'       => $password,
            'department_id'  => 2,
            'reports_to_id'  => $headMarketing->id, // <--- Conexión clave
            'reports_to'     => $headMarketing->FirstName,
        ]);

        // Desarrollador (Reporta a Bill Gates) - TU USUARIO DE PRUEBA
        User::create([
            'name'           => 'Desarrollador Backend',
            'username'       => 'dev_jonathan',
            'FirstName'      => 'Jonathan',
            'LastName'       => 'Cantu',
            'email'          => 'jonathan@empresa.com',
            'password'       => $password,
            'department_id'  => 3,
            'reports_to_id'  => $headIT->id, // <--- Conexión clave
            'reports_to'     => $headIT->FirstName,
        ]);

        // Otro Desarrollador
        User::create([
            'name'           => 'Desarrollador Frontend',
            'username'       => 'dev_front',
            'FirstName'      => 'Laura',
            'LastName'       => 'Code',
            'email'          => 'laura@empresa.com',
            'password'       => $password,
            'department_id'  => 3,
            'reports_to_id'  => $headIT->id,
            'reports_to'     => $headIT->FirstName,
        ]);
    }
}
