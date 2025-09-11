<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('tiporol');
    }

    public function index(){
        $rutas = DB::table('rutas')
        ->select('nombre_ruta', 'id')
        ->get();
        return view('ventas.index')->with('rutas',$rutas);
    }

    public function busquedaProducto($busqueda){

        $productos = DB::table('productos')
        ->select('id','nombre','descripcion','precio_menudeo','existencia','fktipo','precio_mayoreo')
        ->where([
            ['nombre', 'like', '%'.$busqueda.'%'],
            ['estatus_produ', '=' , 1]
            ])
        ->limit(10)
        ->get();
        $data = array();
        foreach($productos as $datos){
            $sub_array = array();

            $sub_array['botones'] = '<button type="button" name="producto" value="'.$datos->id.'-'.$datos->existencia.'-'.$datos->descripcion.'-'.$datos->precio_menudeo.'-'.$datos->precio_mayoreo.'- " class="btn btn-outline-info btn-block resultprodu">'.$datos->nombre.'</button>'.'<br>';
            $data[] = $sub_array;
        }

        return $data;
    }

    public function registrarVenta(Request $req) {
        if (!isset($req['lista_productos']) || count($req['lista_productos']) <= 0) {
            return response()->json([
                'ok' => false,
                'message' => 'No hay productos en la venta.'
            ]);
        }

        $id_venta = DB::table('ventas')->insertGetId([
            'id_ruta' => $req['id_ruta'],
            'fecha_de_venta' => DB::Raw('sysdate()'),
            'total' => $req['totalfin']
        ]);

        foreach ($req['lista_productos'] as $producto) {
            DB::table('ventas_productos')->insertGetId([
                'id_venta' => $id_venta,
                'id_producto' => $producto['id_producto'],
                'costo_unitario' => $producto['costo_unitario'],
                'cantidad' => $producto['cantidad'],
                'subtotal' => $producto['subtotal']
            ]);

            //Actualizar existencia
            $existencia = DB::table('productos')
            ->select('existencia')
            ->where('productos.id','=', $producto['id_producto'])
            ->first();

            $nuevo = $existencia->existencia - $producto['cantidad'];
            DB::table('productos')
            ->where('id','=', $producto['id_producto'])
            ->update(['existencia' => $nuevo]);

            //LLenar inventario x ruta
            $existe = DB::table('inventario_rutas')
            ->where([
                        ['id_ruta','=', $req['id_ruta']],
                        ['id_producto','=', $producto['id_producto']]
                    ])
            ->count();
            if($existe > 0){
                //update
                $existencia = DB::table('inventario_rutas')
                ->select('cantidad')
                ->where([
                    ['id_ruta','=', $req['id_ruta']],
                    ['id_producto','=', $producto['id_producto']]
                ])
                ->first();
                $nuevoinven = $existencia->cantidad + $producto['cantidad'];
                DB::table('inventario_rutas')
                ->where([
                    ['id_ruta','=', $req['id_ruta']],
                    ['id_producto','=', $producto['id_producto']]
                ])
                ->update(['cantidad' => $nuevoinven],
                        ['updated_at' => DB::Raw('sysdate()')]
                    );
            }else{
                // insertar
                DB::table('inventario_rutas')->insertGetId([
                    'id_producto' => $producto['id_producto'],
                    'id_ruta' => $req['id_ruta'],
                    'cantidad' => $producto['cantidad']
                ]);
            }
        }

        return response()->json([
            'ok' => true,
            'message' => 'Venta realizada con éxito'
        ]);
    }

    public function historialVenta(){
        return view('ventas.historial');
    }
    public function VentaxRuta(){
        $rutas = DB::table('rutas')
        ->select('nombre_ruta', 'id')
        ->get();
        return view('ventas.ruta')->with('rutas',$rutas);
    }

    public function ventasData(){
        $ventas = DB::table('ventas')
        ->join('rutas','ventas.id_ruta', '=', 'rutas.id')
        ->get();
        return DataTables::of($ventas)
        ->make(true);
    }

    public function ticket($id){
        //SELECT total, fecha_de_venta,costo_unitario,cantidad,subtotal,descripcion,nombre_ruta FROM `ventas`
        //INNER JOIN ventas_productos ON ventas_productos.id_venta = ventas.id_ventas
        //INNER JOIN productos ON productos.id = ventas_productos.id_producto INNER JOIN rutas ON ventas.id_ruta = rutas.id WHERE id_ventas =7
        $venta = DB::table('ventas')
        ->join('rutas', 'ventas.id_ruta' ,'=', 'rutas.id')
        ->where('ventas.id_ventas', '=', $id)
        ->get();
        $consulta = DB::table('ventas_productos')
        ->join('productos', 'productos.id' ,'=', 'ventas_productos.id_producto')
        ->where('id_venta', '=', $id)
        ->get();


        //dd($data);
        $data = [
                    'producto' => $consulta,
                    'venta' => $venta
                ];

        return PDF::loadView('ventas.pdf', $data)
            ->stream('ticket.pdf', array("Attachment" => false));
    }


    public function busquedaproductoRuta($ruta,$busqueda){
        $productos = DB::table('productos')
        ->select('id','nombre','descripcion','precio_menudeo','existencia','fktipo','precio_mayoreo')
        ->where([
            ['nombre', 'like', '%'.$busqueda.'%'],
            ['estatus_produ', '=' , 1]
            ])
        ->limit(10)
        ->get();

        $data = array();
        $cantidad = 0;
        foreach($productos as $datos){
            $existencia = DB::table('inventario_rutas')
                ->where([
                    ['id_ruta','=', $ruta],
                    ['id_producto','=', $datos->id]
                ])
                ->get();

            foreach($existencia as $productoexiste){
                $cantidad = $productoexiste->cantidad;
            }
            if($cantidad > 0){
                $sub_array = array();
                $sub_array['botones'] = '<button type="button" name="producto" value="'.$datos->id.'-'.$cantidad.'-'.$datos->descripcion.'-'.$datos->precio_menudeo.'-'.$datos->precio_mayoreo.' " class="btn btn-outline-info btn-block resultprodu">'.$datos->descripcion.'</button>'.'<br>';
                $data[] = $sub_array;
            }

        }

        return $data;
    }

    // Modificar los cambios para que se guarden en la tabla nueva de ventasx ruta

    public function registrarVentaRuta(Request $req) {
        if (!isset($req['lista_productos']) || count($req['lista_productos']) <= 0) {
            return response()->json([
                'ok' => false,
                'message' => 'No hay productos en la venta.'
            ]);
        }


        foreach ($req['lista_productos'] as $producto) {
            DB::table('venta_x_rutas')->insertGetId([
                'id_ruta' => $req['id_ruta'],
                'id_producto' => $producto['id_producto'],
                'costo' => $producto['costo_unitario'],
                'cantidad' => $producto['cantidad'],
                'subtotal' => $producto['subtotal'],
                'total' => $req['totalfin'],
                'tipo_movi' => $producto['tiporegistro'],
                'dispositivo' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            //Actualizar existencia

            $existe = DB::table('inventario_rutas')
            ->where([
                        ['id_ruta','=', $req['id_ruta']],
                        ['id_producto','=', $producto['id_producto']]
                    ])
            ->count();
            if($existe > 0){
                //update
                $existencia = DB::table('inventario_rutas')
                ->select('cantidad')
                ->where([
                    ['id_ruta','=', $req['id_ruta']],
                    ['id_producto','=', $producto['id_producto']]
                ])
                ->first();
                $nuevoinven = $existencia->cantidad - $producto['cantidad'];
                DB::table('inventario_rutas')
                ->where([
                    ['id_ruta','=', $req['id_ruta']],
                    ['id_producto','=', $producto['id_producto']]
                ])
                ->update(['cantidad' => $nuevoinven],
                        ['updated_at' => DB::Raw('sysdate()')]
                    );
            }
        }

        return response()->json([
            'ok' => true,
            'message' => 'Venta realizada con éxito'
        ]);
    }

    // Reporte por ruta de ventas
    public function reporteRuta(){
        $fecha = request()->get('fecha');
        $vehiculo = request()->get('rutavheculoselect');

        $consulta = DB::table('venta_x_rutas')
        ->select('venta_x_rutas.cantidad','venta_x_rutas.costo','subtotal','total','tipo_movi','venta_x_rutas.created_at','productos.descripcion', 'inventario_rutas.cantidad as abordo')
        ->join('productos', 'productos.id' ,'=', 'venta_x_rutas.id_producto')
        ->join('inventario_rutas', function ($join) {
            $join->on('venta_x_rutas.id_ruta', '=', 'inventario_rutas.id_ruta');
            $join->on('venta_x_rutas.id_producto', '=', 'inventario_rutas.id_producto');
        })
        ->where([
                [DB::raw('DATE_FORMAT(venta_x_rutas.created_at,"%Y-%m-%d")'),'=', $fecha],
                ['venta_x_rutas.id_ruta', '=', $vehiculo],
             ])
        ->get();

        //dd($data);
        $data = [
                 'data' => $consulta,
                 'ruta' => $vehiculo,
                 'fecha' => $fecha
                ];

        return PDF::loadView('ventas.pdfRutas', $data)
            ->stream('ventaxrutas.pdf', array("Attachment" => false));
    }
}
