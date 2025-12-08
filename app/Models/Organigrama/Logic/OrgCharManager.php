<?php
namespace App\Models\Organigrama\Logic;

use App\Models\Users\Persistence\Eloquent\Repository\UserRepository;
use App\Models\Settings\Persistence\Eloquent\Repository\SettingRepository;
use App\Models\Organigrama\Services\FormatDataOrgChart;
use App\Models\Departments\Persistence\Eloquent\Repository\DepartmentRepository;

class OrgCharManager
{
    protected UserRepository $userRepository;
    protected SettingRepository $settingRepository;
    protected FormatDataOrgChart $formatter;
    protected DepartmentRepository $departmentRepository;

    public function __construct(UserRepository $userRepository, SettingRepository $settingRepository, FormatDataOrgChart $formatter, DepartmentRepository $departmentRepository)
    {
        $this->userRepository = $userRepository;
        $this->settingRepository = $settingRepository;
        $this->formatter = $formatter;
        $this->departmentRepository = $departmentRepository;
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
    
    public function getColorsforDepartment(): array
{
    // DEPARTAMENTOS desde DB
    $departments = $this->departmentRepository->getOnlyDepartments();

    // SETTINGS: Colores configurados en DB
    $colors_json = $this->settingRepository->findSetting('8', 'DepartmentColors');
    $configuredColors = json_decode($colors_json, true);

    if (!is_array($configuredColors)) {
        $configuredColors = [];
    }

    return $this->formatColors($departments, $configuredColors);
}
private function formatColors(array $departments, array $configuredColors): array
{
    $result = [];

    foreach ($departments as $dept) {
        $name = $dept['department'];

        // Si el departamento existe en settings, úsalo
        if (isset($configuredColors[$name])) {
            $result[$name] = $configuredColors[$name];
        }
        // De lo contrario asigna color default
        else {
            $result[$name] = "#000000"; 
        }
    }

    return $result;
}



    
}