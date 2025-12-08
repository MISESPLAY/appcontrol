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
        return view('organigrama.index');
    }

    public function returnOrg(): JsonResponse
    {
        return response()->json(
            $this->orgCharManager->getHierarchy()
        );
    }

    public function returnColors(): JsonResponse
    {
        return response()->json(
            $this->orgCharManager->getColorsforDepartment()
        );
    }
    public function updateColors(Request $request)
{
    // Validamos que venga un mapa { "Software": "#000000", ... }
    $validated = $request->validate([
        'colors' => 'required|array'
    ]);

    $updated = $this->orgCharManager->updateDepartmentColors($validated['colors']);

    return response()->json([
        'success' => true,
        'colors' => $updated
    ]);
}
}
