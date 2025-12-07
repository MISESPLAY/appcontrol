<?php

namespace App\Models\Settings\Persistence\Eloquent\Repository;

use App\Models\Settings\Persistence\Eloquent\Models\SettingModel as Setting;
use App\Models\Settings\Persistence\Eloquent\Interfaces\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    public function get(string $module, string $key): ?string
    {
        return Setting::where('module', $module)
            ->where('key', $key);
    }

    public function allByModule(string $module): array
    {
        return Setting::where('module', $module)
            ->get()
            ->toArray();
    }

    public function getSettingsByModule(string $module): array
    {
        return Setting::where('module', $module)
            ->pluck('value', 'key')
            ->toArray();
    }
    public function getAllValues(): array
    {
        return Setting::all()->pluck('value')->toArray();
    }

    public function getEmployeesFieldsRequired(): array
    {
        $fields = Setting::where('module', 'UserFields')
            ->where('key', 'fields_required')
            ->value('value');

        return $fields ? explode(',', $fields) : [];
    }
    public function findSetting(string $module, string $key): ?string
    {
        return Setting::where('module', $module)
            ->where('key', $key)
            ->value('value');
    }
}
