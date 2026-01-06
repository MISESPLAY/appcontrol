<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settings\Persistence\Eloquent\Models\SettingModel;


class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Configuración de COLORES por Departamento
        // Module: 8 (Organigrama), Key: DepartmentsColor
        $colors = [
            'Dirección General' => '#000000', // Negro
            'Marketing'         => '#FF5733', // Naranja
            'Software'          => '#33FF57', // Verde Hacker
        ];

        SettingModel::create([
            'module' => '8',
            'key'    => 'DepartmentsColor',
            'value'  => json_encode($colors, JSON_UNESCAPED_UNICODE),
        ]);

        // 2. Configuración de CAMPOS REQUERIDOS
        // Module: 8, Key: UserFields
        // OJO: Aquí definimos qué campos extra traer de la tabla users
        $fields = [
            "FirstName",
            "LastName",
            "department_id", // Importante para el belongsTo
            "reports_to_id", // Importante para la jerarquía
            "username"
        ];

        SettingModel::create([
            'module' => '8',
            'key'    => 'UserFields',
            'value'  => json_encode($fields),
        ]);

        // Aquí puedes agregar más settings si tenías otros...
    }
}

