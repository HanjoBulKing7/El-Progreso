<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarNominaRequest;
use App\Models\MesNomina;
use App\Models\Nomina;
use App\Models\NominaActivo;
use App\Models\NominaPasivo;
use App\Models\NominaPasivoDescuentoExtra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class NominaController extends Controller
{
    public function indexNomina()
    {
        $page = request()->get("page", false);
        $ruta_id = request()->get("ruta_id", false);
        $limit = request()->get("limit", false);
        $orderBy = request()->get("orderBy", 'id');
        $ascending = request()->get("ascending", 1);
        $filters = json_decode(request()->get("filters", "{}"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);

        array_push($columns, 'id', 'formatted_created_at', 'formatted_updated_at');

        if ($ruta_id)
            $nominas = Nomina::where('ruta_id', $ruta_id);
        else
            $nominas = Nomina::query();

        foreach ($filters as $filter => $value) {
            if ($value && $filter != "reload")
                switch ($filter) {
                    case 'formatted_created_at':
                    case 'formatted_updated_at':
                        $filter = $filter == 'formatted_created_at' ? 'created_at' : 'updated_at';
                        $dates = explode(" a ", $value);
                        if (count($dates) > 1)
                            $nominas = $nominas->whereBetween($filter, [$dates[0], $dates[1]]);
                        else
                            $nominas = $nominas->whereDate($filter, $dates[0]);
                        break;
                    default:
                        $nominas = $nominas->where($filter, 'LIKE', '%' . $value . '%');
                        break;
                }
        }

        $order = $ascending === "1" ? 'DESC' : 'ASC';
        switch ($orderBy) {
            case 'formatted_created_at':
            case 'formatted_updated_at':
                $orderBy = $orderBy === 'formatted_created_at' ? 'created_at' : 'updated_at';
                $nominas->orderBy($orderBy, $order);
                break;
            default:
                $nominas->orderBy($orderBy, $order);
                break;
        }


        $data = $nominas->get();
        $count = $data->count();

        if ($limit && $page)
            $data = $data->slice(($page - 1) * $limit)->take($limit)->values();


        $data = $data->map(function ($_data) use ($columns) {
            $_data = $_data->only($columns);
            return $_data;
        });

        return compact("data", "count");
    }

    public function show($id)
    {
        dd($id);
    }


    private function generarPasivos($request)
    {
        $pasivos = new NominaPasivo();
        $pasivos->infonavit = $request['pasivos']['infonavit'];
        $pasivos->prestamo = $request['pasivos']['prestamo'];
        $pasivos->faltante = $request['pasivos']['faltante'];
        $pasivos->devolucion = $request['pasivos']['devolucion'];
        $pasivos->descuento_por_falta = $request['pasivos']['descuento_por_falta'];
        $pasivos->descuento_extra = $request['pasivos']['descuento_extra_total'];
        $pasivos->save();

        if (isset($request['pasivos']['descuento_extra']))
            foreach ($request['pasivos']['descuento_extra'] as $descuento_extra) {
                $pasivos_extra = new NominaPasivoDescuentoExtra();
                $pasivos_extra->cantidad = $descuento_extra['cantidad'];
                $pasivos_extra->descripcion = $descuento_extra['descripcion'];
                $pasivos_extra->nomina_pasivo_id = $pasivos['id'];

                $pasivos_extra->save();
            }

        return $pasivos;
    }

    private function generarActivos($request)
    {
        $tiene_bono_mensual = filter_var($request['activos']['tiene_bono_mensual'], FILTER_VALIDATE_BOOL);

        $pasivos = new NominaActivo();
        $pasivos->sueldo_base = $request['activos']['sueldo_base'];
        $pasivos->ayuda_transporte = $request['activos']['ayuda_transporte'];
        $pasivos->ayuda_despensa = $request['activos']['ayuda_despensa'];
        $pasivos->comision = $request['activos']['comision'];
        $pasivos->bono_servicio_cliente = $request['activos']['bono_servicio_cliente'];
        $pasivos->bono_personal = $request['activos']['bono_personal'];
        $pasivos->bono_devolucion = $request['activos']['bono_devolucion'];
        $pasivos->bono_mensual = $tiene_bono_mensual ? $request['activos']['bono_mensual'] : 0;
        $pasivos->save();

        return $pasivos;
    }

    public function guardarNomina(GuardarNominaRequest $request)
    {
        try{
            $pasivos = $this->generarPasivos($request);
            $activos = $this->generarActivos($request);
            $nomina_ruta = new Nomina();

            $comienza_en = explode(' a ', $request->mes)[0];
            $finaliza_en = explode(' a ', $request->mes)[1];
            $nomina_ruta->comienza_en = $comienza_en;
            $nomina_ruta->finaliza_en = $finaliza_en;
            $nomina_ruta->ruta_id = $request->ruta_id;
            $nomina_ruta->total_activos = $request->total_activos;
            $nomina_ruta->total_pasivos = $request->total_pasivos;
            $nomina_ruta->total = $request->total;
            $nomina_ruta->venta_semanal = $request->venta_semanal;
            $nomina_ruta->nomina_pasivo_id = $pasivos->id;
            $nomina_ruta->nomina_activo_id = $activos->id;
            $fechas = explode(" a ", $request->mes);
            $nomina_ruta->inicio_en = $fechas[0];
            $nomina_ruta->final_en = $fechas[1];
            $nomina_ruta->mes_nomina_id = $request->mes_nomina_id;

            $nomina_ruta->save();

            return $nomina_ruta;
        } catch (\Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTrace()
            ], 500);
        }

    }

    public function mostrarNomina($nomina_id)
    {
        $nomina = Nomina::findOrFail($nomina_id);
        $informacion = [];
        $informacion['ruta_id'] = $nomina->ruta_id;
        $informacion['venta_semanal'] = $nomina->venta_semanal;
        $informacion['total_activos'] = $nomina->total_activos;
        $informacion['total_pasivos'] = $nomina->total_pasivos;
        $informacion['meta_maxima'] = $nomina->meta_maxima;
        $informacion['meta_minima'] = $nomina->meta_minima;
        $informacion['total'] = $nomina->total;
        $informacion['mes'] = $nomina->inicio_en . ' to ' . $nomina->final_en;

        $nomina_pasivo = $nomina->nomina_pasivo;

        $informacion['pasivos']['infonavit'] = $nomina_pasivo->infonavit;
        $informacion['pasivos']['prestamo'] = $nomina_pasivo->prestamo;
        $informacion['pasivos']['faltante'] = $nomina_pasivo->faltante;
        $informacion['pasivos']['devolucion'] = $nomina_pasivo->devolucion;
        $informacion['pasivos']['descuento_por_falta'] = $nomina_pasivo->descuento_por_falta;
        $informacion['pasivos']['descuento_extra'] = [];
        $informacion['pasivos']['descuento_extra_total'] = 0;

        $descuentos_extra = $nomina_pasivo->nomina_pasivo_descuento_extra;
        foreach ($descuentos_extra as $descuento_extra) {
            array_push($informacion['pasivos']['descuento_extra'], [
                'cantidad' => $descuento_extra->cantidad,
                'descripcion' => $descuento_extra->descripcion,
            ]);
            $informacion['pasivos']['descuento_extra_total'] += $descuento_extra->cantidad;
        }

        $nomina_activo = $nomina->nomina_activo;

        $informacion['activos']['sueldo_base'] = $nomina_activo['sueldo_base'];
        $informacion['activos']['ayuda_transporte'] = $nomina_activo['ayuda_transporte'];
        $informacion['activos']['ayuda_despensa'] = $nomina_activo['ayuda_despensa'];
        $informacion['activos']['comision'] = $nomina_activo['comision'];
        $informacion['activos']['bono_servicio_cliente'] = $nomina_activo['bono_servicio_cliente'];
        $informacion['activos']['bono_personal'] = $nomina_activo['bono_personal'];
        $informacion['activos']['bono_devolucion'] = $nomina_activo['bono_devolucion'];


        return $informacion;
    }

    public function actualizarNomina(GuardarNominaRequest $request, $nomina_id)
    {
        $this->borrarNomina($nomina_id);
        return $this->guardarNomina($request);
    }

    public function borrarNomina($nomina_id)
    {
        $nomina = Nomina::findOrFail($nomina_id);
        $nomina->delete();

        return $nomina;
    }

    public function validarPrimerPasoNomina(Request $request)
    {
        $request->validate(
            [
                'mes' => ['required', 'regex:/^\d{4}-\d{2}-\d{2} a \d{4}-\d{2}-\d{2}$/'],
                'meta_minima' => 'required|numeric|min:0|max:999999999',
                'meta_maxima' => 'required|numeric|min:0|max:999999999'
            ]);
    }

    public function validarSegundoPasoNomina(Request $request)
    {
        $request->validate(
            [
                'activos.sueldo_base' => 'required|numeric|min:0|max:999999',
                'activos.ayuda_transporte' => 'required|numeric|min:0|max:999999999',
                'activos.ayuda_despensa' => 'required|numeric|min:0|max:999999999',
                'activos.comision' => 'required|numeric|min:0|max:999999999',
                'activos.bono_servicio_cliente' => 'required|numeric|min:0|max:999999999',
                'activos.bono_personal' => 'required|numeric|min:0|max:999999999',
                'activos.bono_devolucion' => 'required|numeric|min:0|max:999999999',
            ]);
    }

    public function validarTercerPasoNomina(Request $request)
    {
        $request->validate(
            [
                'pasivos.infonavit' => 'required|numeric|min:0|max:999999999',
                'pasivos.prestamo' => 'required|numeric|min:0|max:999999999',
                'pasivos.faltante' => 'required|numeric|min:0|max:999999999',
                'pasivos.devolucion' => 'required|numeric|min:0|max:999999999',
                'pasivos.descuento_por_falta' => 'required|numeric|min:0|max:999999999',
                'pasivos.descuento_extra.*.cantidad' => 'required|numeric|min:0|max:999999',
                'pasivos.descuento_extra.*.descripcion' => 'required|string|min:3|max:50'

            ]);
    }

    public function obtenerOCrearMes($ruta_id, $mes)
    {
        return $this->firstOrNew($ruta_id, $mes);
    }

    private function firstOrNew($ruta_id, $mes)
    {
        $columns = json_decode(request()->get("columns", "[]"), true);
        $year = Carbon::createFromFormat('Y-m', $mes)->year;
        $month = Carbon::createFromFormat('Y-m', $mes)->month;

        $mes_nomina = MesNomina::whereYear('mes', $year)->whereMonth('mes', $month)->where('ruta_id', $ruta_id)->first();
        if (!$mes_nomina) {
            $mes_nomina = new MesNomina();
            $mes_nomina->mes = Carbon::createFromFormat('Y-m', $mes);
            $mes_nomina->meta_minima = 0;
            $mes_nomina->meta_maxima = 1;
            $mes_nomina->ruta_id = $ruta_id;
            $mes_nomina->save();
        }

        $mes_nomina->nominas->where('ruta_id', $ruta_id);
        $nominas = $mes_nomina->nominas->map(function ($mes_nomina) use ($columns) {
            return $mes_nomina->only($columns);
        });
        $mes_nomina = $mes_nomina->toArray();
        $mes_nomina['nominas'] = $nominas;

        return $mes_nomina;
    }

    public function obtenerMetas($mes_nomina)
    {
        $mes_nomina = MesNomina::findOrFail($mes_nomina);

        return [
            'meta_minima' => $mes_nomina->meta_minima,
            'meta_maxima' => $mes_nomina->meta_maxima,

        ];
    }

    public function guardarMetaMaxima($mes_nomina, $cantidad)
    {
        $mes_nomina = MesNomina::findOrFail($mes_nomina);
        $mes_nomina->meta_maxima = $cantidad;
        $mes_nomina->save();

        return [
            'meta_minima' => $mes_nomina->meta_minima,
            'meta_maxima' => $mes_nomina->meta_maxima,
        ];
    }

    public function guardarMetaMinima($mes_nomina, $cantidad)
    {
        $mes_nomina = MesNomina::findOrFail($mes_nomina);
        $mes_nomina->meta_minima = $cantidad;
        $mes_nomina->save();

        return [
            'meta_minima' => $mes_nomina->meta_minima,
            'meta_maxima' => $mes_nomina->meta_maxima,
        ];
    }

    public function imprimirPdf($id)
    {
        $nomina = Nomina::findOrFail($id);
        $nomina->nomina_pasivo;
        $nomina->nomina_activo;
        if (!$nomina->direccion_pdf) {
            $nomina = $this->generateNewDocument($nomina, $id);
        }

        if (!Storage::disk('public')->has($nomina->direccion_pdf)) {
            $nomina = $this->generateNewDocument($nomina, $id);
        }


        return $nomina->direccion_pdf;
    }

    private function generateNewDocument($nomina, $id)
    {
        $data = [
            'user_data' => $nomina->user_data,
            'activos' => $nomina->nomina_activo,
            'pasivos' => $nomina->nomina_pasivo,
            'nomina' => $nomina
        ];
        $pdf = PDF::loadView('pdf.nominas.nominas', compact('data'));
        $direccion_pdf = 'invoices/factura' . $id . '.pdf';
        Storage::put('public/' . $direccion_pdf, $pdf->output());
        $nomina->direccion_pdf = $direccion_pdf;
        $nomina->save();

        return $nomina;
    }
}
