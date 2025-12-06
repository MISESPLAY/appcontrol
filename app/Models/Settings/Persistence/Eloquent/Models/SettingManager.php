<?php

namespace App\Models\Settings\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'module',
        'key',
        'value',
    ];
}