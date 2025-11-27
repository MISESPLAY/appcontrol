<?php
namespace App\Services;

use App\Repositories\LegacyRepository;
use App\CRM\CRMService; // tu clase reutilizable

class OrganigramaService
{
    protected $legacyRepo;
    protected $crm;

    public function __construct(LegacyRepository $legacyRepo, CRMService $crm)
    {
        $this->legacyRepo = $legacyRepo;
        $this->crm = $crm;
    }

    public function getEstructuraJerarquica()
    {
        // 1. Datos del CRM
        $crmEmployees = $this->crm->getEmployees();

        // 2. Datos del sistema antiguo
        $legacyEmployees = $this->legacyRepo->getAll();

        // 3. Mezclar todo
        $todos = array_merge($crmEmployees, $legacyEmployees);

        // 4. Ordenar en jerarquía
        return $this->buildHierarchy($todos);
    }

    private function buildHierarchy($employees)
    {
        // Aquí haces tu organigrama
        $byId = [];
        $tree = [];

        foreach ($employees as $e) {
            $e['children'] = [];
            $byId[$e['id']] = $e;
        }

        foreach ($byId as $id => $e) {
            if ($e['report_to'] === null) {
                $tree[] = &$byId[$id];
            } else {
                $byId[$e['report_to']]['children'][] = &$byId[$id];
            }
        }

        return $tree;
    }
}
