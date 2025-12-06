<?php
namespace App\Models\Settings\Persistence\Eloquent\Interfaces;


interface SettingRepositoryInterface
{
    public function get(string $module, string $key): ?string;
    public function allByModule(string $module): array;
}


