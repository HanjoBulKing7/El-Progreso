@extends('layouts.app')

@section('content')

<section id="team" class="pb-5">
    <div class="container">
        <h5 class="section-title h1">Registros de Tiendas en la App</h5>
    </div>
        <div class="margenes">
            <div class="table-responsive">
                @csrf
                <table id="tabla-app-visita" class="table table-bordered table-hover " style="width:100%">
                    <thead>
                        <tr>
                            <th>Ruta</th>
                            <th>Tienda</th>
                            <th>Colonia</th>
                            <th>Codigo Postal</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Google Maps</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    <div class="container">
    <h5 class="section-title h1">Pedidos desde la App</h5>
    </div>
        <div class="margenes">
            <div class="table-responsive">
                @csrf
                <table id="tabla-app-pedido" class="table table-bordered table-hover " style="width:100%">
                    <thead>
                        <tr>
                            <th>Ruta</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Costo</th>
                            <th>Total</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
</section>

@endsection

@section('scripts')
<script>

    $(function() {
        $('#tabla-app-visita').DataTable({
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
            ajax: '{!! route('appvista.data') !!}',
            columns: [
                { data: 'nombre_ruta'},
                { data: 'nombre_tienda'},
                { data: 'colonia'},
                { data: 'fk_codigo_postal'},
                { data: 'fecha_registro'},
                { data: 'hora_registro'},
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                     var latitud = full.lat;
                     var longitud = full.lng;
                     return '<a href="https://www.google.com/maps?q='+latitud+','+longitud+' " target="_blank" class="btn btn-outline-primary btn-block">Mapa</a>';
                    }
                }
                
            ],
            columnDefs: [
                { targets: 6, "width": "2%"}
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


    $(function() {
        $('#tabla-app-pedido').DataTable({
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
            ajax: '{!! route('apppedidos.data') !!}',
            columns: [
                { data: 'nombre_ruta'},
                { data: 'nombre'},
                { data: 'cantidad_pedido'},
                { data: 'costo_pedido'},
                { data: 'total_pedido'},
                { data: 'creado'}
                
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