<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings\Persistence\Eloquent\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* 
            Modulos
            1 = LOGIN AND REGISTER
            2 = EVENTOS
            3 = ORGANIGRAMA 
        */

        $settings = [
            [
                'module' => '3',
                'key'    => 'field_requieredByBD',
                'value'  => '["name","email","password"]',
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
                    'value'  => $setting['value'],
                ]
            );
        }
    }
}
