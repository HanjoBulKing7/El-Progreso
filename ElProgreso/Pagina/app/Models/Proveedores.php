<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    protected $fillable = [
        'nombre_pro', 'email_pro','apepat','apemat','direccion_pro','telefono_pro','fecha_ingreso_pro'
    ];
}
