<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class appRutaVistaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('apprutavista.index');
    }

    public function AppRutaVistaData()
    {
        $resultado = DB::table('registro_ruta_check as t')
                    ->select('r.nombre_ruta', 't.fecha_registro', 't.hora_registro', 't.lat', 't.lng', 'ti.nombre_tienda', 'ti.fk_codigo_postal', 'ti.colonia')
                    ->join('rutas as r', 't.id_ruta', '=', 'r.id')
                    ->join('tiendas as ti', 't.id_tienda', '=', 'ti.id')
                    ->get();
        return DataTables::of($resultado)
            ->make(true);
    }

    public function AppPedidos()
    {
        $resultado = DB::table('pedidos_app as p')
                    ->select('p.cantidad_pedido', 'p.costo_pedido', 'p.total_pedido', 'r.nombre_ruta', 'pr.nombre', 'p.creado')
                    ->join('rutas as r', 'p.id_ruta_pedido', '=', 'r.id')
                    ->join('productos as pr', 'p.id_producto_pedido', '=', 'pr.id')
                    ->get();
        return DataTables::of($resultado)
            ->make(true);
    }
}
