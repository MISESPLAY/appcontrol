<?php

namespace App\Models\Departments\Persistence\Eloquent\Repository;

use App\Models\Departments\Persistence\Eloquent\Models\DepartmentModel as Department;
use App\Models\Departments\Persistence\Eloquent\Interfaces\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function all(): array
    {
        return Department::all()->toArray();
    }

    public function findByName(string $name): ?array
    {
        return Department::where('department', $name)->first()?->toArray() ?? null;
    }

    public function getOnlyDepartments(): array
    {
        return Department::select('department')->get()->toArray();
    }
}
