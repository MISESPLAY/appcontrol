<?php
namespace App\Models\Organigrama\Logic;

use App\Models\Users\Persistence\Eloquent\Repository\UserRepository;
use App\Models\Settings\Persistence\Eloquent\Repository\SettingRepository;
use App\Models\Organigrama\Services\FormatDataOrgChart;

class OrgCharManager
{
    protected UserRepository $userRepository;
    protected SettingRepository $settingRepository;
    protected FormatDataOrgChart $formatter;

    public function __construct(UserRepository $userRepository, SettingRepository $settingRepository, FormatDataOrgChart $formatter)
    {
        $this->userRepository = $userRepository;
        $this->settingRepository = $settingRepository;
        $this->formatter = $formatter;
    }

    public function getHierarchy(): array
    {
        // 1. Obtener empleados
        $employees = $this->userRepository->employees();

        // 2. Obtener configuración
        $fields_required_json = $this->settingRepository->findSetting('8', 'UserFields');
        $fields_required = json_decode($fields_required_json, true);

        if (!is_array($fields_required)) {
            $fields_required = [];
        }

        // --- CORRECCIÓN CRÍTICA ---
        // Definimos campos que el formateador NECESITA sí o sí para funcionar.
        // Si no están, el árbol no se puede armar.
        $mandatory_fields = ['id', 'reports_to_id', 'department', 'FirtName', 'LastName']; 
        
        // Unimos los que pide el usuario + los obligatorios para la lógica
        $all_fields_needed = array_unique(array_merge($fields_required, $mandatory_fields));

        // 3. Filtrar
        $filtered = [];
        foreach ($employees as $employee) {
            $filtered_employee = [];
            foreach ($all_fields_needed as $field) {
                // Usamos null coalescing operator (??) para evitar errores si el campo no existe en DB
                $filtered_employee[$field] = $employee[$field] ?? null;
            }
            $filtered[] = $filtered_employee;
        }

        // 4. Formatear
        return $this->formatter->format($filtered);
    }
}