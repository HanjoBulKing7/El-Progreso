<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominaPasivo extends Model
{


    public function nomina_pasivo_descuento_extra(){
        return $this->hasMany(NominaPasivoDescuentoExtra::class);
    }
}
