<?php

namespace App\Models\Organigrama\Logic;

use App\Models\Departments\Persistence\Eloquent\Repository\DepartmentRepository;
use App\Models\Organigrama\Services\FormatDataOrgChart;
use App\Models\Settings\Persistence\Eloquent\Repository\SettingRepository;
use App\Models\Users\Persistence\Eloquent\Repository\UserRepository;

class OrgCharManager
{
    protected UserRepository $userRepository;
    protected SettingRepository $settingRepository;
    protected FormatDataOrgChart $formatter;
    protected DepartmentRepository $departmentRepository;

    // Constantes para evitar "Magic Strings" y errores de dedo
    const SETTING_KEY_COLORS = 'DepartmentsColor';
    const SETTING_MODULE = '8';

    public function __construct(
        UserRepository $userRepository,
        SettingRepository $settingRepository,
        FormatDataOrgChart $formatter,
        DepartmentRepository $departmentRepository
    ) {
        $this->userRepository = $userRepository;
        $this->settingRepository = $settingRepository;
        $this->formatter = $formatter;
        $this->departmentRepository = $departmentRepository;
    }
    /**
     * Obtiene y procesa la estructura jerárquica de la empresa.
     */
    public function getHierarchy(): array
    {
        // 1. Obtener empleados (asegúrate de usar el 'with' si usas relaciones)
        $employees = $this->userRepository->employees();

        // 2. Obtener el STRING JSON de la base de datos
        // Esto devuelve: '["FirstName","LastName","department","report_to_id"]' (String)
        $json_string = $this->settingRepository->findSetting('8', 'UserFields');

        // 3. CONVERTIR STRING A ARRAY (Decodificar)
        $fields_required = json_decode($json_string, true);

        // Validación de seguridad: Si el JSON está roto o vacío, usamos array vacío
        if (!is_array($fields_required)) {
            $fields_required = [];
        }

        // 4. AGREGAR CAMPOS TÉCNICOS OBLIGATORIOS (¡Muy Importante!)
        // Tu formateador NECESITA 'id' para crear el índice $refs[$id].
        // Si la configuración del usuario no trae 'id', el organigrama se romperá.
        $mandatory_fields = ['id'];

        // 5. Unificar (Merge)
        $all_fields_needed = array_unique(array_merge($mandatory_fields, $fields_required));

        // 6. Filtrar datos (Mapeo)
        $filtered = [];
        foreach ($employees as $employee) {
            $filtered_employee = [];
            foreach ($all_fields_needed as $field) {
                // Aquí usamos el operador ?? por si el campo no existe en la DB
                $filtered_employee[$field] = $employee[$field] ?? null;
            }
            $filtered[] = $filtered_employee;
        }

        return $this->formatter->format($filtered);
    }
    /**
     * Obtiene la lista de departamentos y sus colores asignados.
     */
    public function getColorsforDepartment(): array
    {
        // A. Obtener lista maestra de departamentos
        $departments = $this->departmentRepository->getOnlyDepartments();

        // B. Obtener configuración guardada (JSON string)
        $colors_json = $this->settingRepository->findSetting(self::SETTING_MODULE, self::SETTING_KEY_COLORS);

        // C. Decodificar
        $configuredColors = json_decode($colors_json, true);
        if (!is_array($configuredColors)) {
            $configuredColors = [];
        }

        // D. Mezclar departamentos reales con colores guardados
        return $this->formatColors($departments, $configuredColors);
    }

    /**
     * Actualiza los colores en la configuración global.
     * @param array $colors Ejemplo: ["Marketing" => "#FF0000"]
     */
    public function updateDepartmentColors(array $colors): array
    {
        // 1. Convertir array a JSON para guardar en DB
        $jsonColors = json_encode($colors, JSON_UNESCAPED_UNICODE);

        // 2. Guardar usando las constantes (CORRECCIÓN CLAVE)
        $this->settingRepository->updateSetting(
            self::SETTING_MODULE,
            self::SETTING_KEY_COLORS,
            $jsonColors
        );

        // 3. Retornar los datos frescos
        return $this->getColorsforDepartment();
    }

    /**
     * Helper privado para asignar color default si no existe configuración.
     */
    private function formatColors(array $departments, array $configuredColors): array
    {
        $result = [];

        foreach ($departments as $dept) {
            $name = $dept['department'];
            // Si existe en config usa ese color, si no, negro por defecto
            $result[$name] = $configuredColors[$name] ?? "#000000";
        }

        return $result;
    }
}
