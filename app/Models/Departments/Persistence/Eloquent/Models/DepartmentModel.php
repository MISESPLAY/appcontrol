<?php

namespace App\Models\Departments\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    protected $fillable = [
        'department',
        'department_id',
        'value',
    ];

    protected $table = 'departments'; 
}
