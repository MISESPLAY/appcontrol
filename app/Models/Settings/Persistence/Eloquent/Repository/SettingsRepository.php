<?php

namespace App\Models\Settings\Persistence\Eloquent\Repository;

use App\Models\Settings\Persistence\Eloquent\Setting;
use App\Models\Settings\Persistence\Eloquent\Interfaces\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    public function get(string $module, string $key): ?string
    {
        return Setting::where('module', $module)
                      ->where('key', $key)
                      ->value('value');
    }

    public function allByModule(string $module): array
    {
        return Setting::where('module', $module)
                      ->get()
                      ->toArray();
    }
}
