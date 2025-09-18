@extends('layouts.app')

@section('content')

<section id="team" class="pb-5">
    <div class="container">
        <h5 class="section-title h1">Tiendas</h5>
    </div>
        <div class="margenes">
            <div class="table-responsive">
                @csrf
                <table id="tabla-tiendas" class="table table-bordered table-hover " style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre Tienda</th>
                            <th>Responsable</th>
                            <th>Direccion</th>
                            <th>Colonia</th>
                            <th>Codigo Postal</th>
                            <th>Telefono</th>
                            <th>Estatus</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="floating-arriba">
            <a href="{{ url('/tiendas/create') }}" class="btn btn-primary btn-fab">
                <i class="fa fa-user-plus"> Agregar Tienda</i>
            </a>
            {{ Form::open(['url' => '/generate-pdf/', 'method' => 'GET','id' => 'qrform','autocomplete'=>'off']) }}
                <select class="form-control" id="idruta" name="idruta">
                    @foreach ($listarutas as $ruta)
                        <option value="{{ $ruta->id }}">{{ $ruta->nombre_ruta }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">
                    Crear QR
                </button>
            {{ Form::close() }}
        </div>
</section>

@endsection

@section('scripts')
<script>

    $(function() {
        $('#tabla-tiendas').DataTable({
            dom: '<"top"lB>frt<"bottom"ip>',
            buttons: [
                    {
                        extend: 'csv',
                        title: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: null,
                    },
                    {
                        extend: 'pdf',
                        title: null
                    }
                    
                ],
            processing: true,
            serverSide: true,
            ajax: "{!! route('tienda.data ') !!}",
            columns: [
                { data: 'nombre_tienda', name: 'nombre_tienda' },
                { data: 'responsable_tienda', name: 'responsable_tienda' },
                { data: 'direccion_tienda', name: 'direccion_tienda'},
                { data: 'colonia', name: 'colonia'},
                { data: 'fk_codigo_postal', name: 'fk_codigo_postal'},
                { data: 'tel_tienda', name: 'tel_tienda' },
                { data: 'estatus_tienda', name: 'estatus_tienda' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var buttonID = full.id;
                        return '<a href="/tiendas/'+buttonID+'/edit" class="btn btn-outline-primary btn-block">Editar</a><a href="qr/generar/'+buttonID+'" class="btn btn-outline-primary btn-block">Generar Qr</a>';
                    }
                },
                
            ],
            columnDefs: [
                { targets: 6, "width": "2%",
                    "render": function ( data, type, row, meta ) {
                        if ( row['estatus_tienda'] == 1 ) {
                            return 'Activo';
                        }else{
                            return 'Baja'
                        }
                    }
                },
            ],
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            order: [[4, "asc"]],
            "lengthMenu": [[10, 25, 50, 100, 500,-1], [10, 25, 50, 100, 500,"todos"]],
        });
    });
    </script>

@endsection