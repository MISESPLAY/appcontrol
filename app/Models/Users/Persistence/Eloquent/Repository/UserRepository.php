<?php

namespace App\Models\Users\Persistence\Eloquent\Repository;
use App\Models\User;
use App\Models\Users\Persistence\Eloquent\Interface\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function all(): array
    {
        return User::all()->toArray();
    }

    public function employees(): array
    {
        return User::whereNotNull('reports_to_id')->get()->toArray();
    }

    public function managers(): array
    {
        return User::whereNull('reports_to_id')->get()->toArray();
    }

    public function findByDepartment(string $department): array
    {
        return User::where('department', $department)->get()->toArray();
    }
}
