<?php

namespace App\Models\Users\Persistence\Eloquent\Interface;
interface UserRepositoryInterface
{
    public function all(): array;
    public function employees(): array;
    public function managers(): array;
    public function findByDepartment(string $department): array;
}
