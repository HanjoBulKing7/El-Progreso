<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProveedorController extends Controller
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
        return view('proveedores.index');
    }
    //funcion para el data table
    public function proveedorData(){
        $proveedores = DB::table('proveedores')
        // ->join('rol_usuarios', 'rol_usuarios.id_rol', '=', 'users.fktiporol')
        // ->where('deleted_at','=', null)
        ->get();
        return DataTables::of($proveedores)
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedor = new Proveedores;
        return view('proveedores.create',["productos" => $proveedor]);
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
            'nombre_prove' => 'required|max:100',
            'apepat' => 'required|max:100',
            'direccion' => 'required|max:512',
            'fecharegistro' => 'required|max:100',
        ];
        $this->validate($request,$reglas);

        $proveedor = new Proveedores;

        $proveedor->nombre_pro = $request->nombre_prove;
        $proveedor->apepat_pro = $request->apepat;
        $proveedor->apemat_pro = $request->apemat;
        $proveedor->direccion_pro  = $request->direccion;
        $proveedor->telefono_pro   = $request->telefono;
        $proveedor->email_pro  = $request->correo;
        $proveedor->fecha_ingreso_pro = $request->fecharegistro;

        if ($proveedor->save()) {
            return redirect('/proveedores');
        }else{
            return view('/proveedores/create');
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
        $proveedor = Proveedores::find($id);
        return view('proveedores.edit')->with('proveedor',$proveedor);
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
            'nombre_prove' => 'required|max:100',
            'apepat' => 'required|max:100',
            'direccion' => 'required|max:512',
            'fecharegistro' => 'required|max:100',
        ];
        $this->validate($request,$reglas);

        $proveedor = Proveedores::find($id);
        $proveedor->nombre_pro = $request->nombre_prove;
        $proveedor->apepat_pro = $request->apepat;
        $proveedor->apemat_pro = $request->apemat;
        $proveedor->direccion_pro  = $request->direccion;
        $proveedor->telefono_pro   = $request->telefono;
        $proveedor->email_pro  = $request->correo;
        $proveedor->fecha_ingreso_pro = $request->fecharegistro;

        // Para la baja
        $proveedor->estatus_pro = $request->baja;
        $proveedor->fecha_baja_pro = $request->fechabaja;
        $proveedor->motivo_baja_pro = $request->motivobaja;

        if ($proveedor->save()) {
            return redirect("proveedores");
        }else{
            return view('proveedores.edit')->with('proveedor',$proveedor);
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
