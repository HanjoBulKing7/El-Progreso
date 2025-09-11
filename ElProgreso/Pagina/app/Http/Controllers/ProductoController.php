<?php

namespace App\Http\Controllers;

use App\Models\movimientoProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('tiporol');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('productos.index');
    }

    public function productoData(){
        $productos = DB::table('productos')
        // ->join('rol_usuarios', 'rol_usuarios.id_rol', '=', 'users.fktiporol')
        // ->where('deleted_at','=', null)
        ->get();
        return DataTables::of($productos)
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = DB::table('tipo_productos')
        ->select('id_tipo','nombre_produc','descripcion_produc')
        ->get();
        $proveedor = DB::table('proveedores')
        ->select('id','nombre_pro')
        ->where('estatus_pro','=', 1)
        ->get();
        return view('productos.create')->with('tipos',$tipos)->with('proveedores',$proveedor);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
            'nombre' => 'required|max:100',
            'descripcion' => 'required|max:100',
            'costo' => 'required|max:100',
            'precio_venta' => 'required|max:100',
            'precio_menudeo' => 'required|max:100',
            'precio_mayoreo' => 'required|max:100',
            'cantidad' => 'required|max:100',
            'proveedor'  => 'required|max:100',
            'fecharegistro'  => 'required|max:100',
        ];
        // $messages = [
        //     'nombre.required' => 'Agrega el nombre del producto.',
        //     'descripcion.required' =>'Agregar la descripcion del producto.',
        // ];
        // si lo mensaje se quieren poner locales se agregan aqui y se manda la variable en la funcion de abajo
        // los mensajes ahorita estan en el archivo de validate en lenguage

        $this->validate($request,$reglas);

        $producto = new Producto;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->fktipo  = $request->tipo;
        $producto->costo   = $request->costo;
        $producto->precio_venta  = $request->precio_venta;
        $producto->precio_menudeo = $request->precio_menudeo;
        $producto->precio_mayoreo = $request->precio_mayoreo;
        $producto->existencia = $request->cantidad;
        $producto->fk_proveedor = $request->proveedor;
        $producto->fecha_registro_prod  = $request->fecharegistro;

        if ($producto->save()) {
            // return back()->with('status','Datos cargados correctamente');
            return redirect('/productos');
        }else{
            return back();
            // return view('/productos/create')->with('mensaje','Faltan campos por llenar');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $producto = Producto::find($id);
        $producto = DB::table('productos')
        ->select('productos.id','productos.nombre','productos.descripcion','nombre_produc','productos.costo','productos.precio_venta','productos.precio_menudeo','productos.precio_mayoreo','productos.existencia','nombre_pro','proveedores.id as idproveedor','productos.fecha_registro_prod','productos.estatus_produ','productos.motivo_baja_produ','productos.fecha_baja_produ','productos.fktipo','tipo_productos.descripcion_produc')
        ->join('tipo_productos', 'tipo_productos.id_tipo', '=', 'productos.fktipo')
        ->join('proveedores', 'proveedores.id', '=', 'productos.fk_proveedor')
        ->where('productos.id','=', $id)
        ->get();

        $tipos = DB::table('tipo_productos')
        ->select('id_tipo','nombre_produc','descripcion_produc')
        ->get();
        $proveedor = DB::table('proveedores')
        ->select('id','nombre_pro')
        ->where('estatus_pro','=', 1)
        ->get();
        return view('productos.edit')->with('producto',$producto)->with('tipos',$tipos)->with('proveedores',$proveedor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reglas = [
            'nombre' => 'required|max:100',
            'descripcion' => 'required|max:100',
            'costo' => 'required|max:100',
            'precio_venta' => 'required|max:100',
            'precio_menudeo' => 'required|max:100',
            'precio_mayoreo' => 'required|max:100',
            'cantidad' => 'required|max:100',
            'proveedor'  => 'required|max:100',
            'fecharegistro'  => 'required|max:100',
        ];
        $this->validate($request,$reglas);

        $existencia = DB::table('productos')
        ->select('existencia')
        ->where('productos.id','=', $id)
        ->get();

        foreach($existencia as $numexistencia){
            $comparar_existencia = $numexistencia->existencia;
        }

        if($comparar_existencia != $request->cantidad){
            $movimiento = new movimientoProducto;
            $movimiento->fk_producto = $id;
            $movimiento->cantidad = $request->cantidad;
            $movimiento->tipo_mov = 'alta';
            $movimiento->fecha_mov = $request->fecharegistro;
            $movimiento->save();
        }

        $nuevaexistencia = $comparar_existencia + $request->cantidad;

        $producto = Producto::find($id);
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->fktipo  = $request->tipo;
        $producto->costo   = $request->costo;
        $producto->precio_venta  = $request->precio_venta;
        $producto->precio_menudeo = $request->precio_menudeo;
        $producto->precio_mayoreo = $request->precio_mayoreo;
        $producto->existencia = $nuevaexistencia;
        $producto->fk_proveedor = $request->proveedor;
        $producto->fecha_registro_prod  = $request->fecharegistro;

        // Para la baja
        $producto->estatus_produ = $request->baja;
        $producto->fecha_baja_produ = $request->fechabaja;
        $producto->motivo_baja_produ = $request->motivobaja;

        if ($producto->save()) {
            return redirect("productos");
        }else{
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ingresar(){
        return view('productos.ingresar');
    }

    public function busquedaProductoIngreso($busqueda){

        $productos = DB::table('productos')
        ->select('id','descripcion','costo')
        ->where([
            ['nombre', 'like', '%'.$busqueda.'%'],
            ['estatus_produ', '=' , 1]
            ])
        ->limit(10)
        ->get();
        $data = array();
        foreach($productos as $datos){
            $sub_array = array();

            $sub_array['botones'] = '<button type="button" name="producto" value="'.$datos->id.'-'.$datos->descripcion.'-'.$datos->costo.' " class="btn btn-outline-info btn-block resultprodu">'.$datos->descripcion.'</button>'.'<br>';
            $data[] = $sub_array;
        }

        return $data;
    }

    public function registrarCompra(Request $req){
        if (!isset($req['lista_productos']) || count($req['lista_productos']) <= 0) {
            return response()->json([
                'ok' => false,
                'message' => 'No hay productos en la Compra.'
            ]);
        }

        $id_compra = DB::table('compras')->insertGetId([
            'lote' => $req['lote'],
            'total' => $req['total']
        ]);


        foreach ($req['lista_productos'] as $producto) {
            DB::table('compras-productos')->insertGetId([
                'fk_lote' => $id_compra,
                'id_producto' => $producto['id_producto'],
                'cantidad' => $producto['cantidad'],
                'costo' => $producto['costo_unitario'],
                'subtotal' => $producto['subtotal']
            ]);
            //Actualizar existencia
            $existencia = DB::table('productos')
            ->select('existencia')
            ->where('productos.id','=', $producto['id_producto'])
            ->first();

            $nuevo = $existencia->existencia + $producto['cantidad'];
            DB::table('productos')
            ->where('id','=', $producto['id_producto'])
            ->update(['existencia' => $nuevo]);

        }

        return response()->json([
            'ok' => true,
            'message' => 'Compra realizada con éxito'
        ]);
    }

    public function historialCompra(){
        return view('productos.historial');
    }

    public function compraData(){
        $compra = DB::table('compras')
        ->get();
        return DataTables::of($compra)
        ->make(true);
    }

    public function ticket($id){
        //SELECT total, fecha_de_venta,costo_unitario,cantidad,subtotal,descripcion,nombre_ruta FROM `ventas`
        //INNER JOIN ventas_productos ON ventas_productos.id_venta = ventas.id_ventas
        //INNER JOIN productos ON productos.id = ventas_productos.id_producto INNER JOIN rutas ON ventas.id_ruta = rutas.id WHERE id_ventas =7
        $compra = DB::table('compras')
        ->where('id', '=', $id)
        ->get();
        $consulta = DB::table('compras-productos')
        ->join('productos', 'productos.id' ,'=', 'compras-productos.id_producto')
        ->where('fk_lote', '=', $id)
        ->get();


        //dd($data);
        $data = [
                    'producto' => $consulta,
                    'compra' => $compra
                ];

        return PDF::loadView('productos.pdf', $data)
            ->stream('ticket.pdf', array("Attachment" => false));
    }
}
