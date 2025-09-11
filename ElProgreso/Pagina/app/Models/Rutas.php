<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rutas extends Model
{
    //
    protected $table = 'rutas';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function nominas(){
        return $this->hasMany(Nomina::class);
    }

    public function venta_x_ruta(){
        return $this->hasMany(venta_x_ruta::class, 'id_ruta');
    }
}
