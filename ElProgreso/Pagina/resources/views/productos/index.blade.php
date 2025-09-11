@extends('layouts.app')

@section('content')

<section id="team" class="pb-5">
    <div class="container">
        <h5 class="section-title h1">Productos</h5>
    </div>
        <div class="margenes">
            <div class="table-responsive">
                @csrf
                <table id="tabla-proveedor" class="table table-bordered table-hover " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Costo</th>
                            <th>Precio Venta</th>
                            <th>Precio Menudeo</th>
                            <th>Precio Mayoreo</th>
                            <th>Existencia</th>
                            <th>Proveedor</th>
                            <th>Estatus</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="floating-arriba">
            <a href="{{ url('/productos/create') }}" class="btn btn-primary btn-fab">
                <i class="fa fa-user-plus"> Agregar Producto</i>
            </a>
            <a href="{{ url('/ingresar') }}" class="btn btn-primary btn-fab">
                <i class="fa fa-user-plus"> Ingresars Producto</i>
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
            ajax: '{!! route('producto.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre', name: 'nombre' },
                { data: 'descripcion', name: 'descripcion' },
                { data: 'fktipo', name: 'fktipo'},
                { data: 'costo', name: 'costo' },
                { data: 'precio_venta', name: 'precio_venta' },
                { data: 'precio_menudeo', name: 'precio_menudeo' },
                { data: 'precio_mayoreo', name: 'precio_mayoreo' },
                { data: 'existencia', name: 'existencia' },
                { data: 'fk_proveedor', name: 'fk_proveedor' },
                { data: 'estatus_produ', name: 'estatus_produ' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                     var buttonID = full.id;
                     return '<a href="/productos/'+buttonID+'/edit" class="btn btn-outline-primary btn-block">Editar</a>';
                 }
                },
                
            ],
            columnDefs: [
                { targets: 10, "width": "2%",
                    "render": function ( data, type, row, meta ) {
                        if ( row['estatus_produ'] == 1 ) {
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
            order: [[5, "asc"]],
            "lengthMenu": [[10, 25, 50, 100, 500,-1], [10, 25, 50, 100, 500,"todos"]],
        });
    });
    </script>

@endsection