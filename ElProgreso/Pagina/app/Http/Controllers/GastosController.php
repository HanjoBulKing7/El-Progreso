<?php

namespace App\Http\Controllers;

use App\Models\Gastos;
use App\Models\TipoGasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GastosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('tiporol');
    }

    public function index()
    {
        $totalMes = Gastos::totalMes();
        $totalAnio = Gastos::totalAnio();
        // $totalMesCount = Gastos::totalMesCount();

        $tipogastos = DB::table('tipo_gastos')
        ->select('id', 'tipogasto','estatus_tipogasto')
        ->where('estatus_tipogasto','=', 1)
        ->get();
        return view('gastos.index',['tipogasto' => $tipogastos,'totalMes' => $totalMes,'totalAnio' => $totalAnio]);
    }

    public function gastosmesData(){
        $gastos = DB::table('gastos')
        ->select('gastos.id','tipo_gastos.tipogasto','descripcion_gasto','costo_gasto','fecha_gasto','estatus_gasto')
        ->join('tipo_gastos','gastos.fk_tipogasto','=','tipo_gastos.id')
        ->whereMonth('fecha_gasto', '=', date('m'))
        ->get();
        return DataTables::of($gastos)
        ->make(true);
    }

    public function gastosData(){
        $gastos = DB::table('gastos')
        ->select('gastos.id','tipo_gastos.tipogasto','descripcion_gasto','costo_gasto','fecha_gasto','estatus_gasto')
        ->join('tipo_gastos','gastos.fk_tipogasto','=','tipo_gastos.id')
        ->whereYear('fecha_gasto', date('Y'))
        ->get();
        return DataTables::of($gastos)
        ->make(true);
    }

    // creacion de metodos para la baja de ruta por vehiculo
    public function gastoBaja($id){
        $gastobaja = Gastos::find($id);
        $gastobaja->estatus_gasto = 0;

        if($gastobaja->save()){
            return 1;
        }else{
            return 0;
        }
    }

    // creacion de metodos para la baja de ruta por vehiculo
    public function gastoActivo($id){
        $gastoalta = Gastos::find($id);
        $gastoalta->estatus_gasto = 1;

        if($gastoalta->save()){
            return 2;
        }else{
            return 0;
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
            'tipogasto' => 'required|max:20',
            'descripcion' => 'required|max:100',
            'costo' => 'required',
            'fechagasto' => 'required|max:100'
        ];

        $this->validate($request,$reglas);

        $gastosg = new Gastos;

        $gastosg->fk_tipogasto = $request->tipogasto;
        $gastosg->descripcion_gasto = $request->descripcion;
        $gastosg->costo_gasto = $request->costo;
        $gastosg->fecha_gasto = $request->fechagasto;

        if($gastosg->save()){
            return 1;
        }else{
            return 2;
        }

    }

    public function tipoGastos(Request $request){
        $reglas = [
            'tipogastoadd' => 'required|max:100',
        ];

        $this->validate($request,$reglas);

        $tipogasto = new TipoGasto;
        $tipogasto->tipogasto = $request->tipogastoadd;

        if($tipogasto->save()){
            return 1;
        }else{
            return 0;
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
        //
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
        //
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
}
