<?php
namespace App\Models\Departments\Persistence\Eloquent\Interfaces;

interface DepartmentRepositoryInterface

{
    public function all(): array;
    public function findByName(string $name): ?array;
}


