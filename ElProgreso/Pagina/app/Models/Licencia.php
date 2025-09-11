<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    protected $fillable = [
        'fk_usuario', 'no_licencia','fecha_exp','estatus_lic'
    ];
}
