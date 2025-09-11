<?php

namespace App\Http\Controllers;

use App\Models\BonoAnual;
use App\Http\Requests\BonoAnualStoreRequest;
use Illuminate\Http\Request;

class BonoAnualController extends Controller
{
    public function guardarBonoAnual(BonoAnualStoreRequest $request, $year)
    {
        $bono_anual = BonoAnual::where('year', $year);
        if (!$bono_anual->exists()) {
            $bono_anual = new BonoAnual();
        } else {
            $bono_anual = $bono_anual->first();
        }
        $bono_anual->bono = $request->bono;
        $bono_anual->year = $request->year;
        $bono_anual->save();

        return $bono_anual;
    }

    public function obtenerBonoAnual($year)
    {
        $bono_anual = BonoAnual::where('year', $year);
        if (!$bono_anual->exists()) {
            $bono_anual = new BonoAnual();
            $bono_anual->bono = 0;
            $bono_anual->year = $year;
            $bono_anual->save();
        } else {
            $bono_anual = $bono_anual->first();
        }

        return $bono_anual;

    }

}
