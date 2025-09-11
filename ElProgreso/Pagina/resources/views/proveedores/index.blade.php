@extends('layouts.app')

@section('content')

<section id="team" class="pb-5">
    <div class="container">
        <h5 class="section-title h1">Proveedores</h5>
    </div>
        <div class="margenes">
            <div class="table-responsive">
                @csrf
                <table id="tabla-proveedor" class="table table-bordered table-hover " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Feacha de Registro</th>
                            <th>Estatus</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="floating-arriba">
            <a href="{{ url('/proveedores/create') }}" class="btn btn-primary btn-fab">
                <i class="fa fa-user-plus"> Agregar Proveedor</i>
            </a>
        </div>
</section>

@endsection

@section('scripts')
<script>

    $(function() {
        $('#tabla-proveedor').DataTable({
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
            ajax: '{!! route('proveedor.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre_pro', name: 'nombre' },
                { data: 'apepat_pro', name: 'apepat' },
                { data: 'apemat_pro', name: 'apemat'},
                { data: 'telefono_pro', name: 'telefono' },
                { data: 'direccion_pro', name: 'Direccion' },
                { data: 'fecha_ingreso_pro', name: 'fecha_ingreso' },
                { data: 'estatus_pro', name: 'estatus' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                     var buttonID = full.id;
                     return '<a href="proveedores/'+buttonID+'/edit" class="btn btn-outline-primary btn-block">Editar</a>';
                 }
                },
                
            ],
            columnDefs: [
                { targets: 7, "width": "2%",
                    "render": function ( data, type, row, meta ) {
                        if ( row['estatus_pro'] == 1 ) {
                            return 'Activo';
                        }else{
                            return 'Baja'
                        }
                    }
                }
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
            order: [[0, "asc"]],
            "lengthMenu": [[10, 25, 50, 100, 500,-1], [10, 25, 50, 100, 500,"todos"]],
        });
    });
    </script>

@endsection