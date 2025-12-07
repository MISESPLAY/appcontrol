<?php
namespace App\Models\Organigrama\Services;

class FormatDataOrgChart
{
    public function format(array $employees): array
    {
        $refs = []; 
        $structure = [
            'directivos'    => [],
            'departamentos' => []
        ];

        // PASO 1: Indexar
        foreach ($employees as $e) {
            // Validación de seguridad: Si no hay ID, saltamos este registro
            if (empty($e['id'])) continue;

            $id = $e['id'];
            
            // Construimos el nombre con seguridad (evita error si es null)
            $firstName = $e['FirstName'] ?? ''; // Ojo con el typo 'FirtName'
            $lastName = $e['LastName'] ?? '';
            $fullName = trim($firstName . ' ' . $lastName);

            $refs[$id] = [
                'id'            => $id,
                'name'          => $fullName ?: 'Sin Nombre', // Fallback visual
                'department'    => $e['department'] ?? null,
                'reports_to_id' => $e['reports_to_id'] ?? null,
                'employees'     => [] 
            ];
        }

        // PASO 2: Construir árbol (Referencias)
        foreach ($employees as $e) {
            // Validamos que existan las claves antes de usarlas
            if (empty($e['id'])) continue;
            
            $id = $e['id'];
            $bossId = $e['reports_to_id'] ?? null;

            if ($bossId && isset($refs[$bossId])) {
                $refs[$bossId]['employees'][] = &$refs[$id];
            }
        }

        // PASO 3: Agrupar Raíces
        foreach ($refs as &$node) {
            // Si tiene jefe válido, ya está dentro de otro nodo, lo ignoramos aquí
            if (!empty($node['reports_to_id']) && isset($refs[$node['reports_to_id']])) {
                continue;
            }

            // Clasificación
            if (empty($node['department'])) {
                $structure['directivos'][] = $node;
            } else {
                $deptName = $node['department'];
                $structure['departamentos'][$deptName][] = $node;
            }
        }

        return $structure;
    }
}