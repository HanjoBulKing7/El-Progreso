<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gastos extends Model
{
    protected $fillable = ['fk_tipogasto', 'descripcion_gasto', 'costo_gasto', 'fecha_gasto', 'status_gasto',];

    public static function totalMes(){
        $total = DB::table('gastos')
        ->select('costo_gasto','fecha_gasto')
        ->whereMonth('fecha_gasto', '=', date('m'))
        ->where('estatus_gasto','=', 1)
        ->sum('costo_gasto');

        return $total;
        // return Gastos::monthly()->sum("costo_gasto");
    }

    // public static function totalMesCount(){
    //     return Gastos::monthly()->count();
    // }

    public static function totalAnio(){
        $totalanio = DB::table('gastos')
        ->select('costo_gasto','fecha_gasto')
        ->whereYear('fecha_gasto', date('Y'))
        ->where('estatus_gasto','=', 1)
        ->sum('costo_gasto');

        return $totalanio;
        // return Gastos::yearly()->sum("costo_gasto");
    }

    // public static function totalAnioCount(){
    //     return Gastos::yearly()->count();
    // }
}
