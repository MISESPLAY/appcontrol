<?php

namespace App\Models\Organigrama\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Organigrama\Logic\OrgCharManager;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrgcharController extends Controller
{
    protected OrgCharManager $orgCharManager;

    public function __construct(OrgCharManager $orgCharManager)
    {
        $this->orgCharManager = $orgCharManager;
    }

    public function index()
    {
        return view('index');
    }

    /**
     * Retorna la jerarquía de empleados formateada para el organigrama.
     */
    public function returnOrg(): JsonResponse
    {
        return response()->json(
            $this->orgCharManager->getHierarchy()
        );
    }

    /**
     * Retorna el mapa de colores actuales por departamento.
     */
    public function returnColors(): JsonResponse
    {
        return response()->json(
            $this->orgCharManager->getColorsforDepartment()
        );
    }

    /**
     * Recibe los nuevos colores, valida y solicita la actualización.
     * Espera un JSON: { "colors": { "Marketing": "#FF0000", ... } }
     */
    public function updateColorsDepartment(Request $request): JsonResponse
    {
        // 1. Validación estricta de entrada
        $validated = $request->validate([
            'colors' => 'required|array'
        ]);

        // 2. Delegar la lógica al Manager
        $updated = $this->orgCharManager->updateDepartmentColors($validated['colors']);

        // 3. Responder al cliente
        return response()->json([
            'success' => true,
            'colors' => $updated // Retornamos los datos actualizados para confirmar
        ]);
    }
}
