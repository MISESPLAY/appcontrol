<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departments\Persistence\Eloquent\Models\DepartmentModel;

class DepartmentsSeeder extends Seeder
{
   
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'department'     => 'Sales',
                'department_id'  => '30',
                'value'          => ''
            ],
            [
                'department'     => 'Marketing',
                'department_id'  => '20',
                'value'          => 'Gestión de personal'
            ],
            [
                'department'     => 'Software',
                'department_id'  => '10',
                'value'          => ''
            ],
            [
                'department'     => 'HR',
                'department_id'  => '40',
                'value'          => ''
            ],
           
        ];

        foreach ($departments as $dept) {
            DepartmentModel::updateOrCreate(
                [
                    'department_id' => $dept['department_id'], // clave única
                ],
                [
                    'department' => $dept['department'],
                    'value'      => $dept['value'],
                ]
            );
        }
    }  //
    
}
