<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings\Persistence\Eloquent\Models\SettingsModel as settings;
 


class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'module' => '3',
                'key'    => 'field_requieredByBD',
                'value'  => '["FirstName","LastName","department","department_id","reports_to_id"]',
            ],
            [
                'module' => '1',
                'key'    => 'login_attempts',
                'value'  => '5',
            ],
            [
                'module' => '2',
                'key'    => 'events_enabled',
                'value'  => 'true',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                [
                    'module' => $setting['module'],
                    'key'    => $setting['key'],
                ],
                [
                    'value' => $setting['value'],
                ]
            );
        }
    }
}
