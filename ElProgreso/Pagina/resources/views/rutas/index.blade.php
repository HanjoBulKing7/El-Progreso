@extends('layouts.app')

@section('content')

<section id="team" class="pb-5">
    <div class="container">
        <h5 class="section-title h1">Rutas</h5>
    </div>
@include('layouts.mensaje')
    <div class="container-mod">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <h3 class="titulocenter">Tabla de Rutas</h3>
                <div class="table-responsive">
                    <table id="tabla-rutas" class="table table-bordered table-hover " style="width:100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nombre</th>
                                <th>Estatus</th>
                                <th>Vendedor</th>
                                <th>Accion</th>
                                <th>Agregar Tienda a Ruta</th>
                                <th>Agregar Vehiculo a Ruta</th>
                                <th>Nóminas de mes</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
            <div class="col-md-8 col-lg-8 col-sm-12">
                <h3 class="titulocenter">Rutas por Tienda</h3>
                <div class="table-responsive">
                    <table id="tabla-rutas_tienda" class="table table-bordered table-hover " style="width:100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nombre Ruta</th>
                                <th>Nombre de la Tienda</th>
                                <th>Dias Visita</th>
                                <th>Colonia</th>
                                <th>Codigo Postal</th>
                                <th>Estatus</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12">
                <h3 class="titulocenter">Rutas por Vehiculo</h3>
                <div class="table-responsive">
                    <table id="tabla-rutas_vehiculo" class="table table-bordered table-hover " style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Ruta</th>
                                <th>Vehiculo</th>
                                <th>KM del Vehiculo</th>
                                <th>Estatus</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

    </div>


        <div class="floating-arriba">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rutac">
                <span data-toggle="modal" data-target="#id">
                    <a data-toggle="tooltip" data-placement="top" title="añadir nuevo tipo de producto"><i class="fa fa-user-plus"> Crear Ruta</i></a>
                </span>
            </button>
        </div>
</section>

<!-- Modal crear ruta-->
<div class="modal fade" id="rutac" tabindex="-1" role="dialog" aria-labelledby="rutacLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rutacLabel">Crear nueva Ruta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{ Form::open(['url' => '/rutas/', 'method' => 'POST']) }}
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Nombre de la Ruta</p>
                            <input id="nombre_ruta" type="text" class="form-control @error('nombre_ruta') is-invalid @enderror" name="nombre_ruta" placeholder="Nombre de la Ruta">
                            @error('nombre_ruta')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Usuario asignado</p>
                            <select class="form-control" id="user_id" name="user_id">
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>

                            @error('$usuario')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>
  {{ Form::close() }}
  {{-- fin modal  --}}

  <!-- Modal editar ruta -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="rutacLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rutacLabel">Editar Ruta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{ Form::open(['url' => '/rutas/', 'method' => 'PUT','id' => 'formeditruta']) }}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <input type="hidden" id="idhidden">
                            <p>Nombre de la Ruta</p>
                            <input id="nombre_rutaed" type="text" class="form-control @error('nombre_rutaed') is-invalid @enderror" name="nombre_rutaed">
                            @error('nombre_rutaed')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Usuario asignado</p>
                            <select class="form-control" id="user_id" name="user_id">
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>

                            @error('$usuario')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Fecha de baja de la Ruta</p>
                            <input id="fechabaja" value="" type="text" class="form-control" name="fechabaja">
                            <script>
                                var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                  $('#fechabaja').datepicker({
                                      uiLibrary: 'bootstrap4',
                                      minDate: '1940-12-31',
                                      maxDate: today,
                                      locale: 'es-es',
                                      format: 'yyyy-mm-dd',
                                  });
                            </script>
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Motivo de baja de la Ruta</p>
                            <textarea name="motivobaja" id="motivobaja" class="form-control" rows="3" placeholder="Motivo de la baja"></textarea>
                        </div>

                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="editguardar">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>
  {{ Form::close() }}
  {{-- fin del modal editar  --}}

  <!-- Modal agregar tienda a ruta -->
  <div class="modal fade" id="Modaltiendaruta" tabindex="-1" role="dialog" aria-labelledby="rutacLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rutacLabel">Agregar tienda a Ruta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{ Form::open(['url' => '/gtiendaruta/', 'method' => 'POST','id' => 'agregartienda']) }}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <input type="hidden" id="idhiddenruta" name="idhiddenruta">
                            <p>Nombre de la Ruta</p>
                            <input id="nombre_rutatr" type="text" class="form-control" name="nombre_rutaed">
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Tienda</p>
                            <input id="tienda" type="text" class="form-control" name="tienda">
                            <input type="hidden" id="idhiddentienda" name="idhiddentienda">
                            <div class="justify-content-left" >
                                <div id="resultadobusqueda"></div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12 p-3">
                            <label for="dias">Días de Visita: </label>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="lunes" name="lunes" value="lunes">
                                <label class="custom-control-label" for="lunes">Lunes</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="martes" name="martes" value="martes">
                                <label class="custom-control-label" for="martes">Martes</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="miercoles" name="miercoles" value="miercoles">
                                <label class="custom-control-label" for="miercoles">Miercoles</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="jueves" name="jueves" value="jueves">
                                <label class="custom-control-label" for="jueves">Jueves</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="viernes" name="viernes" value="viernes">
                                <label class="custom-control-label" for="viernes">Viernes</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="sabado" name="sabado" value="sabado">
                                <label class="custom-control-label" for="sabado">Sabado</label>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="tiendaguardar">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>
  {{ Form::close() }}
  {{-- fin  Modal agregar tienda a ruta  --}}

  <!-- Modal agregar vehiculo a ruta -->
  <div class="modal fade" id="Modalrutavehiculo" tabindex="-1" role="dialog" aria-labelledby="rutacLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rutacLabel">Agregar Vehiculo a Ruta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{ Form::open(['url' => '/rutavehiculo/', 'method' => 'POST','id' => 'agregarvehiculoruta']) }}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <input type="hidden" id="idhiddenrutav" name="idhiddenrutav">
                            <p>Nombre de la Ruta</p>
                            <input id="nombre_rutaveh" type="text" class="form-control" name="nombre_rutaveh">
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Vehiculo</p>
                            <select class="form-control" id="rutavheculoselect" name="rutavheculoselect">
                                @foreach ($vehiculos as $item)
                                    <option value="{{ $item->id }}">{{ $item->vehiculo." - KM:".$item->km_actual_veh }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="vehiculoguardar">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>
  {{ Form::close() }}
  {{-- fin  Modal agregar tienda a ruta  --}}

@endsection

@section('scripts')
<script>
    // rutas a vehiculos
    $(function() {
        $('#tabla-rutas_vehiculo').DataTable({
            "pageLength": 5,
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
            ajax: '{!! route('ruta.vehiculo.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre_ruta', name: 'ruta' },
                { data: 'vehiculo', name: 'vehiculo' },
                { data: 'km_actual_veh', name: 'km_actual_veh' },
                { data: 'status_vehiculo_ruta', name: 'estatus' },
                {
                    sortable: false,
                    "width": "2%",
                    "render": function ( data, type, full, meta ) {
                     var buttonID = full.id;
                    return '<button type="button" class="btn btn-outline-danger btn-block rv_baja" value="'+buttonID+'"><i class="fa fa-trash" ></i></button>'
                    // return '<a href="/proveedores/'+buttonID+'/edit" class="btn btn-outline-primary btn-block">Editar</a>';
                 }
                },

            ],
            columnDefs: [
                { targets: 4,
                    "render": function ( data, type, row, meta ) {
                        if ( row['status_vehiculo_ruta'] == 1 ) {
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
            order: [[0, "asc"]],
            "lengthMenu": [[5,10, 25, 50, 100, 500,-1], [5,10, 25, 50, 100, 500,"todos"]],
        });
    });
    // abrir en modal cargando el nombre de la ruta
    $(document).on('click','.agrvehiculo',function(){
        // var token = $('[name="_token"]').val();
        var id = $(this).val();
        var url = '/rutas/'+id+'/edit'
        $.ajax({
            url: url,
            type: "get",
            dataType: "json",
            success: function(data){
                $('#nombre_rutaveh').val(data.nombre_ruta)
                $('#idhiddenrutav').val(data.id)
                $("#Modalrutavehiculo").modal()
            }
        });
    });
    $(document).on('click','#vehiculoguardar',function(){
        var form = $('#agregarvehiculoruta')
        var url = 'rutavehiculo'
   		var data = form.serialize()
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "html",
            success: function(data){
                console.log(data)
                if(data == 1){
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })
                    Toast.fire({
                    icon: 'success',
                    title: 'Vehiculo asignado a la ruta '
                    })
                    $('#tabla-rutas_vehiculo').DataTable().ajax.reload();
                    $('#Modalrutavehiculo').modal('hide');
                }else if(data == 2){
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'warning',
                    title: 'Ya existe una Ruta para ese Vehiculo'
                    })
                }else{
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'No se puedo asignar el vehiculo'
                    })
                }
            }
        });
    });
    //dar de baja ruta de la tabla de vehiculos
    $(document).on('click','.rv_baja',function(){
        var id = $(this).val();
        var url = '/rv_baja/'+id
        Swal.fire({
            title: '¿Estás seguro de eliminar el registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'No, Cancelar',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                    url: url,
                    type: "get",
                    dataType: "json",
                        success: function(data){
                            if (data == 1) {
                                if (result.value) {
                                    Swal.fire(
                                    'Eliminado!',
                                    'EL vehiculo fue eliminado de la ruta .',
                                    'success'
                                    )
                                }
                                $('#tabla-rutas_vehiculo').DataTable().ajax.reload()
                            }else{
                                Swal.fire(
                                    'NO Eliminado!',
                                    'No se pudo eliminar el vehiculo de la ruta',
                                    'error'
                                )
                            }
                        }
                    });
                }
            })

    });
    // *************** Fin ruta a vehiculo******
    $(function() {
        $('#tabla-rutas').DataTable({
            "pageLength": 5,
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
            ajax: '{!! route('ruta.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre_ruta', name: 'nombre' },
                { data: 'estatus_ruta', name: 'estatus' },
                { data: 'vendedor', name: 'vendedor'},
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                     var buttonID = full.id;
                    return '<button type="button" class="btn btn-outline-primary btn-block"  value="'+buttonID+'">Editar</button>'
                    // return '<a href="/proveedores/'+buttonID+'/edit" class="btn btn-outline-primary btn-block">Editar</a>';
                 }
                },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                     var buttonID = full.id;
                    return '<button type="button" class="btn btn-outline-info btn-block agregartienda"  value="'+buttonID+'">Agregar tienda</button>'
                    // return '<a href="/proveedores/'+buttonID+'/edit" class="btn btn-outline-primary btn-block">Editar</a>';
                 }
                },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                     var buttonID = full.id;
                    return '<button type="button" class="btn btn-outline-warning btn-block agrvehiculo" value="'+buttonID+'">Agregar Vehiculo</button>'
                    // return '<a href="/proveedores/'+buttonID+'/edit" class="btn btn-outline-primary btn-block">Editar</a>';
                 }
                },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var buttonID = full.id;
                        return'<a href="rutas/'+buttonID+'/nominas"> <button type="button" class="btn btn-outline-warning btn-block agregar-meta" value="'+buttonID+'">Agregar nómina</button> </a>'

                        // return '<a href="/proveedores/'+buttonID+'/edit" class="btn btn-outline-primary btn-block">Editar</a>';
                    }
                },

            ],
            columnDefs: [
                { targets: 2, "width": "2%",
                    "render": function ( data, type, row, meta ) {
                        if ( row['estatus_ruta'] == 1 ) {
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
            "lengthMenu": [[5,10, 25, 50, 100, 500,-1], [5,10, 25, 50, 100, 500,"todos"]],
        });
    });

    $(document).on('click','.btn-outline-primary',function(){


        var id = $(this).val();
        var url = '/rutas/'+id+'/edit'
        $.ajax({
            url: url,
            type: "get",
            dataType: "json",
            success: function(data){
                $('#nombre_rutaed').val(data.nombre_ruta)
                $('#idhidden').val(data.id)
                $('#fechabaja').val(data.fechabaja_ruta)
                $('#motivobaja').val(data.motivobaja_ruta)
                $("#myModal").modal()
            }
        });
    });

    $(document).on('click','#editguardar',function(){
        var id = $('#idhidden').val()
        var form = $('#formeditruta')
        var url = 'rutas'
   		var data = form.serialize()
   		url = url+'/'+ id
        // console.log(data)
        $.ajax({
            url: url,
            type: "put",
            data: data,
            dataType: "html",
            success: function(data){
                if(data == 1){
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-start',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })
                    Toast.fire({
                    icon: 'success',
                    title: 'Ruta Actualizada'
                    })
                    $('#tabla-rutas').DataTable().ajax.reload();
                    $('#myModal').modal('hide')
                    $('#tabla-rutas_vehiculo').DataTable().ajax.reload()
                    $('#tabla-rutas_tienda').DataTable().ajax.reload()
                }else{
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-start',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'La ruta NO se actualizo'
                    })
                }
            }
        });
    });
    // ************************ Agregar tienda ***************************
    $(function() {
        $('#tabla-rutas_tienda').DataTable({
            "pageLength": 5,
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
            ajax: '{!! route('ruta.tienda.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre_ruta', name: 'nombreruta' },
                { data: 'nombre_tienda', name: 'nombretienda' },
                { data: 'dias_visita_tienda', name: 'dias_visita_tienda' },
                { data: 'colonia', name: 'colonia' },
                { data: 'fk_codigo_postal', name: 'cp' },
                { data: 'status_tienda_ruta', name: 'estatus'},
                {
                    sortable: false,
                    "width": "2%",
                    "render": function ( data, type, full, meta ) {
                     var buttonID = full.id;
                    return '<button type="button" class="btn btn-outline-danger btn-block rt_baja" value="'+buttonID+'"><i class="fa fa-trash" ></i></button>'
                    // return '<a href="/proveedores/'+buttonID+'/edit" class="btn btn-outline-primary btn-block">Editar</a>';
                 }
                },

            ],
            columnDefs: [
                { targets: 6, "width": "2%",
                    "render": function ( data, type, row, meta ) {
                        if ( row['status_tienda_ruta'] == 1 ) {
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
            "lengthMenu": [[5,10, 25, 50, 100, 500,-1], [5,10, 25, 50, 100, 500,"todos"]],
        });
    });
    //dar de baja rutatienda
    $(document).on('click','.rt_baja',function(){
        var id = $(this).val();
        var url = '/rt_baja/'+id
        Swal.fire({
            title: '¿Estás seguro de eliminar el registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'No, Cancelar',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                    url: url,
                    type: "get",
                    dataType: "json",
                        success: function(data){
                            if (data == 1) {
                                if (result.value) {
                                    Swal.fire(
                                    'Eliminado!',
                                    'La tienda fue eliminada de la ruta.',
                                    'success'
                                    )
                                }
                                $('#tabla-rutas_tienda').DataTable().ajax.reload()
                            }else{
                                Swal.fire(
                                    'NO Eliminado!',
                                    'No se pudo eliminar la tienda de la ruta',
                                    'error'
                                )
                            }
                        }
                    });
                }
            })

    });
    // abrir en modal cargando el nombre de la ruta
    $(document).on('click','.agregartienda',function(){
        var id = $(this).val();
        var url = '/rutas/'+id+'/edit'
        $.ajax({
            url: url,
            type: "get",
            dataType: "json",
            success: function(data){
                $('#nombre_rutatr').val(data.nombre_ruta)
                $('#idhiddenruta').val(data.id)
                $("#Modaltiendaruta").modal()
            }
        });
    });
    // buscar tiendas con el input
    $(document).on('keyup','#tienda',function(){
        var form = $('#agregartienda')
   		// var url = form.attr('action')
        //    url = url.replace('tiendas','busqueda')
        var url = 'busquedatienda'
   		var inputbusqueda = $(this).val();
   		var data = form.serialize()
   		url = url+'/'+ inputbusqueda

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data){
                $('#resultadobusqueda').empty();
                $('#resultadobusqueda').addClass("card2");
                //$('#resultadobusqueda').append(data);

                for(var i = 0; i< data.length; i++){
                    $('#resultadobusqueda').append(data[i]['botones']);
                }
                if(inputbusqueda == ''){
                    $('#resultadobusqueda').removeClass("card2");
                    $('#resultadobusqueda').empty();
                }
            }
        });
    });
    // click en el boton de los resultados
    $(document).on('click','.resultienda',function(){
        $('#resultadobusqueda').removeClass("card2");
        $('#resultadobusqueda').empty();
        var seleccionb = $(this).val();
        var aqui = seleccionb.split("-")
        $('#idhiddentienda').val(aqui[0])
        $('#tienda').val(aqui[1])
    });

    $(document).on('click','#tiendaguardar',function(){
        var form = $('#agregartienda')
        var url = 'gtiendaruta'
   		var data = form.serialize()
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "html",
            success: function(data){
                if(data == 1){
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-start',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })
                    Toast.fire({
                    icon: 'success',
                    title: 'Tienda agregada a la ruta '
                    })
                    $('#tabla-rutas_tienda').DataTable().ajax.reload();
                    $('#Modaltiendaruta').modal('hide');
                    $('#tienda').val('')
                }else if(data == 2){
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-start',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'warning',
                    title: 'La tienda ya existe en la ruta'
                    })
                    $('#tienda').val('')
                }else{
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-start',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'La tienda no puedo se Agregada'
                    })
                    $('#tienda').val('')
                }
            }
        });
    });
     // ************************ FIN Agregar tienda ***************************
    </script>

@endsection
