<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings\Persistence\Eloquent\Setting;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* 
            
        */

        $user = [
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

 
    }
}
