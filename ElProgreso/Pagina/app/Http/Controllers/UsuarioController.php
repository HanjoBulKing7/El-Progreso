<?php

namespace App\Http\Controllers;

use App\Models\Rutas;
use App\Models\User;
use App\Models\venta_x_ruta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
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
        return view('usuarios.index');
    }

    public function usuarioData()
    {
        $usuario = DB::table('users')
            ->join('rol_usuarios', 'rol_usuarios.id_rol', '=', 'users.fktiporol')
            // ->where('deleted_at','=', null)
            ->get();
        //return DataTables::of(Historico::query())->make(true);
        return DataTables::of($usuario)
            ->make(true);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $usuariosvar = User::find($id);
        $usuariosrol = DB::table('users')
            ->select('rol', 'id_rol')
            ->join('rol_usuarios', 'rol_usuarios.id_rol', '=', 'users.fktiporol')
            ->where('users.id', '=', $id)
            ->get();
        $roles = DB::table('rol_usuarios')
            ->select('rol', 'id_rol', 'descripcion')
            ->get();
        $licenciavar = DB::table('licencias')
            ->select('no_licencia', 'fecha_exp', 'fecha_ven')
            ->where([
                ['fk_usuario', '=', $id],
                ['estatus_lic', '=', 1]
            ])
            ->get();

        // return view('usuarios.edit',["usuarios" => $usuariosvar]);
        return view('usuarios.edit')->with('usuarios', $usuariosvar)->with('estatus', $usuariosrol)->with('roles', $roles)->with('licencia', $licenciavar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reglas = [
            'name' => 'required|max:100',
            'email' => 'required|max:100|email',
        ];
        $this->validate($request, $reglas);

        $usuariosvar = User::find($id);

        if (!is_null($request->password)) {
            $reglas = [
                'password' => 'string|min:8|confirmed',
            ];
            $this->validate($request, $reglas);
            $usuariosvar->password = Hash::make($request->password);
        }

        $hasFile = $request->hasFile('fileToUpload') && $request->fileToUpload->isValid();
        $usuariosvar->name = $request->name;
        $usuariosvar->email = $request->email;
        $usuariosvar->apepat = $request->apepat;
        $usuariosvar->apemat = $request->apemat;
        $usuariosvar->direccion = $request->direccion;
        $usuariosvar->telefono = $request->telefono;
        $usuariosvar->fktiporol = $request->puesto;
        $usuariosvar->fecha_ingreso = $request->fechaingreso;
        $usuariosvar->fecha_nacimiento = $request->fechanacimiento;
        $usuariosvar->salario = $request->salario;
        $usuariosvar->infonavit = $request->infonavit;

        // Para la baja
        $usuariosvar->estatus = $request->baja;
        $usuariosvar->fecha_baja = $request->fechabaja;
        $usuariosvar->motivo_baja = $request->motivobaja;
        if ($hasFile) {
            $extension = $request->fileToUpload->extension();
            $usuariosvar->urlfoto = $extension;
        }

        if ($usuariosvar->save()) {
            if ($hasFile) {
                $request->fileToUpload->storeAs("images", "$usuariosvar->id.$extension");
                //store nombre del archivo de manera dinamica con md5 se puede validar cuando un archivo esta duplicado y con storeAs nosotros definimos el nombre del archivo
            }
            return redirect("usuarios");
        } else {
            return view('usuarios.edit', ["usuarios" => $usuariosvar]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = User::find($id);
        $usuario->estatus = 2;
        $usuario->save();
        //$usuario->delete();
        return redirect("usuarios");
    }

    public function obtenerUsuarioAutenticado()
    {
        return auth()->user();
    }



    public function obtenerVentaYDevolucionesMensuales($ruta_id, $rango_fechas)
    {
        $ruta = Rutas::findOrFail($ruta_id);
        $fechas = explode(" a ", $rango_fechas);
        if (count($fechas) > 1) {
            $total_ventas = $ruta->venta_x_ruta->where('tipo_movi', venta_x_ruta::VENTA)->whereBetween('created_at', [$fechas[0], $fechas[1]])->sum('total');
            $total_devoluciones = $ruta->venta_x_ruta->where('tipo_movi', venta_x_ruta::DEVOLUCION)->whereBetween('created_at', [$fechas[0], $fechas[1]])->sum('total');
            $devoluciones = $this->calcularBonoDevoluciones($total_ventas, $total_devoluciones);

        } else {
            $total_ventas = $ruta->venta_x_ruta()->where('tipo_movi', venta_x_ruta::VENTA)->whereDay('created_at', $fechas[0])->sum('total');
            $total_devoluciones = $ruta->venta_x_ruta()->where('tipo_movi', venta_x_ruta::DEVOLUCION)->whereDay('created_at', $fechas[0])->sum('total');
            $devoluciones = $this->calcularBonoDevoluciones($total_ventas, $total_devoluciones);
        }

        return [
            'total_ventas' => $total_ventas,
            'devoluciones' => $devoluciones
        ];
    }

    private function calcularBonoDevoluciones($total_ventas, $total_devoluciones)
    {
        $credito_devoluciones = $total_ventas * .05;
        $bono_devoluciones = $credito_devoluciones - $total_devoluciones;

        return [
            'activo_devoluciones' => $bono_devoluciones > 0 ? abs($bono_devoluciones) : 0,
            'pasivo_devoluciones' => $bono_devoluciones < 0 ? abs($bono_devoluciones) : 0
        ];
    }
}
