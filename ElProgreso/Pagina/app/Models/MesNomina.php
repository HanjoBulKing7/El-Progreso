<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MesNomina extends Model
{
    public function nominas(){
        return $this->hasMany(Nomina::class);
    }
}
