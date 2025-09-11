<?php

namespace App\Http\Controllers;

use App\Models\RegistroKm;
use App\Models\TipoGasto;
use App\Models\Vehiculo;
use App\Models\registro_checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\DataTables;

class VehiculoController extends Controller
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
        return view('vehiculos.index');
    }

    public function obtenerVehiculo()
    {
        $vehiculo = DB::table('vehiculos')
        ->select('estatus_veh','id','vehiculo','placas_veh')
        ->where('estatus_veh','=', 1)
        ->get()->toArray();
        return $vehiculo;
    }

    public function vehiculoData(){
        $vehiculo = DB::table('vehiculos')
        // ->where('deleted_at','=', null)
        ->get();
        //return DataTables::of(Historico::query())->make(true);
        return DataTables::of($vehiculo)
        ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehiculos.create');
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
            'nombre_vehiculo' => 'required|max:100',
            'marca' => 'required|max:100',
            'modelo' => 'required|max:100',
            'placas' => 'required|max:512',
            'poliza' => 'required|max:100',
        ];
        $this->validate($request,$reglas);

        $vehiculo = new Vehiculo;
        $vehiculo->vehiculo = $request->nombre_vehiculo;
        $vehiculo->marca_veh = $request->marca;
        $vehiculo->modelo_veh = $request->modelo;
        $vehiculo->placas_veh = $request->placas;
        $vehiculo->desc_veh  = $request->descripcion;
        $vehiculo->poliza_veh   = $request->poliza;
        $vehiculo->tel_seg_veh  = $request->tel_seguro;
        $vehiculo->fecha_alta_veh = $request->fechaalta;
        $vehiculo->fecha_com_veh = $request->fechacompra;
        $vehiculo->inicio_seg_veh = $request->inicioseg;
        $vehiculo->fin_seg_veh = $request->finseguro;
        $vehiculo->km_actual_veh = $request->kilometro;
        // se agrega a la tabla de tipo gasto
        $tipogasto = new TipoGasto;
        $tipogasto->tipogasto = $request->nombre_vehiculo;



        if ($vehiculo->save() and $tipogasto->save()) {
            return redirect('/vehiculos');
        }else{
            return view('/vehiculos/create');
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
        $vehiculo = Vehiculo::find($id);
        return view('vehiculos.edit')->with('vehiculo',$vehiculo);
    }

    public function buscarkmVehiculo($id){
        $vehiculo = Vehiculo::find($id);
        return $vehiculo;
    }

    public function guardarkmVehiculo(Request $request){

        $reglas = [
            'kmactual' => 'required|max:100',
            'kmnuevo' => 'required|max:100',
            'fechareg' => 'required|max:100',
        ];
        $this->validate($request,$reglas);

        $kmregistro = new RegistroKm;

        if ($request->kmactual >= $request->kmnuevo) {
            return 2;
        }

        $kmregistro->fk_vehiculo = $request->idhiddidvehiculo;
        $kmregistro->km_actual_regveh = $request->kmactual;
        $kmregistro->km_nuevo_regveh = $request->kmnuevo;
        $kmregistro->fecha_regveh = $request->fechareg;

        $vehiculo = Vehiculo::find($request->idhiddidvehiculo);
        $vehiculo->km_actual_veh = $request->kmnuevo;

        if ($kmregistro->save() and $vehiculo->save()) {
            return 1;
        }else{
            return 0;
        }

    }

    public function crearCheckList(Request $request){
        $registroVehiculo = new registro_checklist;

        $registroVehiculo->fk_vehiculo = $request->idhiddidvehiculonom;

        if($registroVehiculo->save()){
            $idresgistro = $registroVehiculo->id;
        }else{
            // Regresa que no se pudo hacer el registro de la tabla pivote
            return 2;
        }
        DB::table('check_list_vehiculos')->insert([
            [
                "fk_registro" => $idresgistro,
                "aspecto" => "Aceite",
                "estado" => $request->optaceite,
                "observaciones" => $request->comentaceite
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Aceite de Direccion",
                "estado" => $request->optdireccion,
                "observaciones" => $request->comentdireccion
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Liquido de Frenos/Clutch",
                "estado" => $request->optliquido,
                "observaciones" => $request->comentliquido
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Tanque de Gasolina",
                "estado" => $request->optgasolina,
                "observaciones" => $request->comentgasolina
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Luces Altas/Bajas",
                "estado" => $request->optluces,
                "observaciones" => $request->comentluces
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Stop",
                "estado" => $request->optstop,
                "observaciones" => $request->comentstop
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Reversa",
                "estado" => $request->optreversa,
                "observaciones" => $request->comentreversa
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Direcciones/Intermitentes",
                "estado" => $request->optinter,
                "observaciones" => $request->comentinter
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Cuartos",
                "estado" => $request->optcuartos,
                "observaciones" => $request->comentcuartos
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Manijas",
                "estado" => $request->optmanijas,
                "observaciones" => $request->comentmanijas
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Espejos",
                "estado" => $request->optespejos,
                "observaciones" => $request->comentespejos
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Facias",
                "estado" => $request->optfacias,
                "observaciones" => $request->comentfacias
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "LLantas",
                "estado" => $request->optllantas,
                "observaciones" => $request->comentllantas
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Revisión de refacciones",
                "estado" => $request->optrefacc,
                "observaciones" => $request->comentrefacc
            ],[
                "fk_registro" => $idresgistro,
                "aspecto" => "Otro",
                "estado" => $request->optotro,
                "observaciones" => $request->comentotro
            ],
        ]);
        return 1;
    }

    // Reporte de checklist
    public function reporteCheckList(){
        $fecha = request()->get('fecha');
        $vehiculo = request()->get('vehiculo');
        /*
        SELECT * FROM `registro_checklists`
        INNER JOIN check_list_vehiculos ON registro_checklists.id = check_list_vehiculos.fk_registro
        WHERE DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN '2021-03-10' AND '2021-03-10' AND fk_vehiculo = 4
        */
        $consulta = DB::table('registro_checklists')
        ->join('check_list_vehiculos', 'registro_checklists.id' ,'=', 'check_list_vehiculos.fk_registro')
        //->whereBetween(DB::raw('DATE_FORMAT(created_at,"%Y-%m-%d")'), ['2021-03-10', '2021-03-10'])
        ->where([
                [DB::raw('DATE_FORMAT(created_at,"%Y-%m-%d")'),'=', $fecha],
                ['registro_checklists.fk_vehiculo', '=', $vehiculo],
             ])
        ->get();

        //dd($data);
        $data = ['data' => $consulta];

        return PDF\Pdf::loadView('vehiculos.pdf', $data)
            ->stream('archivo.pdf', array("Attachment" => false));
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
            'nombre_vehiculo' => 'required|max:100',
            'marca' => 'required|max:100',
            'modelo' => 'required|max:100',
            'placas' => 'required|max:512',
            'poliza' => 'required|max:100',
        ];
        $this->validate($request,$reglas);

        $vehiculo = Vehiculo::find($id);
        $vehiculo->vehiculo = $request->nombre_vehiculo;
        $vehiculo->marca_veh = $request->marca;
        $vehiculo->modelo_veh = $request->modelo;
        $vehiculo->placas_veh = $request->placas;
        $vehiculo->desc_veh  = $request->descripcion;
        $vehiculo->poliza_veh   = $request->poliza;
        $vehiculo->tel_seg_veh  = $request->tel_seguro;
        $vehiculo->fecha_alta_veh = $request->fechaalta;
        $vehiculo->fecha_com_veh = $request->fechacompra;
        $vehiculo->inicio_seg_veh = $request->inicioseg;
        $vehiculo->fin_seg_veh = $request->finseguro;
        $vehiculo->km_actual_veh = $request->kilometro;

        // Para la baja
        $vehiculo->estatus_veh = $request->baja;
        $vehiculo->fecha_baja_veh = $request->fechabaja;
        $vehiculo->motivo_baja_veh = $request->motivobaja;


        if ($vehiculo->save()) {
            return redirect('/vehiculos');
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
}
