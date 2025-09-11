<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarNominaRequest;
use App\Models\Rutas;
use App\Models\RutaTienda;
use App\Models\User;
use App\Models\VehiculoRuta;
use App\Models\venta_x_ruta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RutaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculo = DB::table('vehiculos')
        ->select('vehiculo', 'id','km_actual_veh')
        ->get();
        $usuarios = User::whereDoesntHave('ruta')->select(['id', 'name'])->get();
        return view('rutas.index')->with('vehiculos',$vehiculo)->with('usuarios', $usuarios);
    }

    public function rutaData(){
        // $ruta = DB::table('rutas')
        // ->get();
        $ruta = DB::table('rutas')
        ->join('users', 'rutas.user_id', '=', 'users.id')
        ->select('rutas.*', DB::raw("CONCAT(users.name, ' ', users.apepat, ' ', users.apemat) as vendedor"))
        ->get();
        return DataTables::of($ruta)
        ->make(true);
    }

    public function rutaTiendaData(){
        $rutatienda = DB::table('ruta_tiendas')
        ->select('ruta_tiendas.id', 'rutas.nombre_ruta','tiendas.nombre_tienda','tiendas.colonia','tiendas.fk_codigo_postal','status_tienda_ruta','dias_visita_tienda')
        ->join('rutas', 'ruta_tiendas.fk_ruta', '=', 'rutas.id')
        ->join('tiendas', 'ruta_tiendas.fk_tienda', '=', 'tiendas.id')
        ->where([
            ['rutas.estatus_ruta','=',1],
            ['ruta_tiendas.status_tienda_ruta','=',1],
            ['tiendas.estatus_tienda','=',1],
            ])
        ->get();
        return DataTables::of($rutatienda)
        ->make(true);
    }

    public function rutaVehiculoData(){
        $rutavehiculo = DB::table('vehiculo_rutas')
        ->select('vehiculo_rutas.id','rutas.nombre_ruta','vehiculos.vehiculo','vehiculos.km_actual_veh','status_vehiculo_ruta')
        ->join('rutas', 'vehiculo_rutas.fk_ruta_vr', '=', 'rutas.id')
        ->join('vehiculos', 'vehiculo_rutas.fk_vehiculo_vr', '=', 'vehiculos.id')
        ->where([
            ['rutas.estatus_ruta','=',1],
            ['vehiculo_rutas.status_vehiculo_ruta','=',1],
            ['vehiculos.estatus_veh','=',1],
            ])
        ->get();
        return DataTables::of($rutavehiculo)
        ->make(true);
    }

    public function busquedaTienda($busqueda){
        $tiendas = DB::table('tiendas')
        ->select('id','nombre_tienda','estatus_tienda','colonia','direccion_tienda')
        ->where([
            ['nombre_tienda', 'like', '%'.$busqueda.'%'],
            ['estatus_tienda', '=' , 1]
            ])
        ->limit(5)
        ->get();
        $data = array();
        foreach($tiendas as $datos){
            $sub_array = array();

            $sub_array['botones'] = '<button type="button" name="idprueba" value="'.$datos->id.'-'.$datos->nombre_tienda.'" class="btn btn-outline-info btn-block resultienda">'.$datos->nombre_tienda.'-'.$datos->colonia.' '.$datos->direccion_tienda.'</button>'.'<br>';
            $data[] = $sub_array;
        }

        return $data;
    }
    // guardar la ruta por tienda
    public function guardartiendaruta(Request $request)
    {
        $dias = $request->lunes.'-'.$request->martes.'-'.$request->miercoles.'-'.$request->jueves.'-'.$request->viernes.'-'.$request->sabado;
        $tiendas = DB::table('ruta_tiendas')
        ->where([
            ['fk_tienda', '=', $request->idhiddentienda],
            ['fk_ruta', '=' , $request->idhiddenruta],
            ['status_tienda_ruta', '=', 1]
            ])
        ->count();

        if ($tiendas != 0) {
            return 2;
        }else{

            $tiendas2 = DB::table('ruta_tiendas')
            ->where([
                ['fk_tienda', '=', $request->idhiddentienda],
                ['fk_ruta', '=' , $request->idhiddenruta],
                ['status_tienda_ruta', '=', 0]
                ])
            ->count();

            if ($tiendas2 != 0) {

                $tiendasupdate = DB::table('ruta_tiendas')
                ->where([
                    ['fk_tienda', '=', $request->idhiddentienda],
                    ['fk_ruta', '=' , $request->idhiddenruta],
                    ['status_tienda_ruta', '=', 0]
                    ])
                ->limit(1)
                ->update(['status_tienda_ruta' => 1,'dias_visita_tienda' => $dias]);

                if ($tiendasupdate) {
                    return 1;
                }else{
                    return 0;
                }
            }else{
                $rutatienda = new RutaTienda;
                $rutatienda->fk_tienda = $request->idhiddentienda;
                $rutatienda->fk_ruta = $request->idhiddenruta;
                $rutatienda->dias_visita_tienda = $dias;

                if ($rutatienda->save()) {
                    return 1;
                }else{
                    return 0;
                }
            }

        }
    }
    // guardar la ruta por vehiculo
    public function rutaVehiculo(Request $request){

        $compvehiculos = DB::table('vehiculo_rutas')
        ->where([
            ['fk_vehiculo_vr', '=', $request->rutavheculoselect],
            ['fk_ruta_vr', '=' , $request->idhiddenrutav],
            ['status_vehiculo_ruta', '=', 1]
            ])
        ->count();

        if ($compvehiculos != 0) {
            return 2;
        }else{

            $compvehiculos = DB::table('vehiculo_rutas')
            ->where([
                ['fk_vehiculo_vr', '=', $request->rutavheculoselect],
                ['fk_ruta_vr', '=' , $request->idhiddenrutav],
                ['status_vehiculo_ruta', '=', 0]
                ])
            ->count();

            if ($compvehiculos != 0) {
                $updatevehiculo = DB::table('vehiculo_rutas')
                ->where([
                    ['fk_vehiculo_vr', '=', $request->rutavheculoselect],
                    ['fk_ruta_vr', '=' , $request->idhiddenrutav],
                    ['status_vehiculo_ruta', '=', 0]
                    ])
                ->limit(1)
                ->update(['status_vehiculo_ruta' => 1]);

                if ($updatevehiculo) {
                    return 1;
                }else{
                    return 0;
                }
            }else{
                $vehiculoruta = new VehiculoRuta;
                $vehiculoruta->fk_vehiculo_vr = $request->rutavheculoselect;
                $vehiculoruta->fk_ruta_vr = $request->idhiddenrutav;

                if ($vehiculoruta->save()) {
                    return 1;
                }else{
                    return 0;
                }
            }


        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nombre_ruta'   => 'required|max:100',
            'user_id'       => 'required|numeric|min:0|exists:users,id'
        ];
        $this->validate($request,$reglas);

        $ruta = new Rutas;

        $ruta->nombre_ruta = $request->nombre_ruta;
        $ruta->user_id = $request->user_id;
        if ($ruta->save()) {
            return redirect('/rutas');
        }else{
            return back();
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
        $ruta = Rutas::find($id);
        return $ruta;
    }

    // creacion de metodos para la baja de ruta por vehiculo
    public function rutaVehiculoBaja($id){
        $rutarv = VehiculoRuta::find($id);
        $rutarv->status_vehiculo_ruta = 0;

        if($rutarv->save()){
            return 1;
        }else{
            return 0;
        }
    }
    // creacion de metodos para la baja de ruta por tienda
    public function rutaTiendaBaja($id){
        $rutatb = RutaTienda::find($id);
        $rutatb->status_tienda_ruta = 0;

        if($rutatb->save()){
            return 1;
        }else{
            return 0;
        }
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

        $ruta = Rutas::find($id);

        if (is_null($request->nombre_rutaed) ) {
            return 0;
        }
        if (!is_null($request->fechabaja) or !is_null($request->motivobaja)) {
            $ruta->estatus_ruta = 0;
        }else{
            $ruta->estatus_ruta = 1;
        }

        $ruta->nombre_ruta = $request->nombre_rutaed;
        $ruta->fechabaja_ruta = $request->fechabaja;
        $ruta->motivobaja_ruta = $request->motivobaja;

        if($ruta->save()){
            return 1;
        }else{
            return 0;
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

    public function obtenerVentasMensuales($ruta_id, $mes)
    {
        $ruta = Rutas::findOrFail($ruta_id);
        $cb = Carbon::createFromFormat('Y-m-d', $mes);
        $cb_end = Carbon::createFromFormat('Y-m-d', $mes);
        $inicio = $cb->startOfMonth();
        $final = $cb_end->endOfMonth();

        $fechas = [$inicio, $final];

        $total_ventas = $ruta->venta_x_ruta->where('tipo_movi', venta_x_ruta::VENTA)->whereBetween('created_at', [$fechas[0], $fechas[1]])->sum('total');


        return $total_ventas;
    }

    public function obtenerUsuarioAsociado($id)
    {
        $ruta = Rutas::find($id);

        if (!$ruta) {
            return response()->json(['error' => 'No se encontro la ruta con id ' . $id], 404);
        }

        $user = $ruta->user;

        if (!$user) {
            return response()->json(['error' => 'No se encontro el usuario asociado a la ruta con id ' . $id], 404);
        }

        return response()->json($user, 200);
    }

}
