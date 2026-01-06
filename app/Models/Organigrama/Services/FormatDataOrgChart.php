<?php
namespace App\Models\Organigrama\Services;

class FormatDataOrgChart
{
    public function format(array $employees): array
    {
        $refs = [];
        // IMPORTANTE: Inicializar la estructura antes de usarla
        $structure = [
            'directivos'    => [],
            'departamentos' => []
        ];

        // PASO 1: Indexar
        foreach ($employees as $e) {
            if (empty($e['id'])) continue;
            $id = $e['id'];

            // --- MAPEO DE NOMBRES ---
            // Mira tu 'dd()' del Paso 1.
            // Si en tu DB es minúscula ('first_name'), cámbialo aquí.
            // Aquí dejo las opciones más comunes:
            $firstName = $e['FirstName'] ?? $e['first_name'] ?? $e['name'] ?? 'Sin Nombre';
            $lastName  = $e['LastName']  ?? $e['last_name']  ?? '';
            $fullName  = trim($firstName . ' ' . $lastName);

            // --- MAPEO DE DEPARTAMENTO ---
            $deptName = 'Sin Departamento';

            // 1. Verificamos si existe la llave 'department' (la relación)
            if (!empty($e['department'])) {
                // 2. Si es un array (Relación belongsTo cargada)
                if (is_array($e['department'])) {
                    // AQUÍ ES DONDE SUELE FALLAR:
                    // Busca en tu 'dd()' cómo se llama la columna del nombre en la tabla departments.
                    // Usualmente es 'name', 'department', 'label' o 'descripcion'.
                    $deptName = $e['department']['name']
                        ?? $e['department']['department']
                        ?? $e['department']['descripcion']
                        ?? 'Depto Desconocido';
                }
                // 3. Si por alguna razón viene como texto plano
                else if (is_string($e['department'])) {
                    $deptName = $e['department'];
                }
            }

            // --- CONSTRUCCIÓN DEL NODO ---
            $refs[$id] = [
                'id'            => $id,
                'name'          => $fullName,
                'title'         => $deptName, // Útil para algunas librerías gráficas
                'department'    => $deptName,
                'reports_to_id' => $e['reports_to_id'] ?? null,
                'children'      => []
            ];
        }

        // PASO 2: Construir Árbol (Jerarquía)
        foreach ($employees as $e) {
            $id = $e['id'];
            $bossId = $e['reports_to_id'] ?? null;

            // Solo si tiene jefe Y el jefe existe en nuestro array procesado ($refs)
            if ($bossId && isset($refs[$bossId])) {
                // Referencia (&): Lo que le pase al hijo aquí, se actualiza en el papá
                $refs[$bossId]['children'][] = &$refs[$id];
            }
        }

        // PASO 3: Separar las Raíces
        // Usamos referencia &$node para no perder la conexión
        foreach ($refs as &$node) {
            // Si tiene jefe válido, NO es raíz (ya está dentro de los children de alguien)
            if (!empty($node['reports_to_id']) && isset($refs[$node['reports_to_id']])) {
                continue;
            }

            // SI LLEGAMOS AQUÍ, ES UNA RAÍZ (Nadie lo manda o su jefe no existe)

            // Lógica de agrupación visual:
            if ($node['reports_to_id'] === null) {
                // Es un CEO o Director Supremo
                $structure['directivos'][] = $node;
            } else {
                // Es un huérfano (tiene jefe ID X, pero el jefe X no vino en la lista)
                // Lo ponemos en su departamento para que no desaparezca
                $deptName = $node['department'];
                $structure['departamentos'][$deptName][] = $node;
            }
        }

        return $structure;
    }
}
