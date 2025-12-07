<?php

namespace App\Models\Settings\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class SettingModel  extends Model
{
    protected $fillable = [
        'module',
        'key',
        'value',
    ];
    protected $table = 'settings'; 
    
}