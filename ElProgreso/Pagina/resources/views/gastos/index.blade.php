@extends('layouts.app')

@section('content')

<section id="team" class="pb-5">
    <div class="container">
        <h5 class="section-title h1">Gastos</h5>
    </div>
@include('layouts.mensaje')
    <div class="container-mod">
        <div class="row">
            
            <div class="col-md-6 col-lg-6 col-sm-12">
                <h3 class="titulocenter">Gastos del mes</h3>
                
				<h4><span>{{ $totalMes }} MXN</span> Gastos del Mes</h4>		
                <div class="table-responsive">
                    <table id="table-gastos_mes" class="table table-bordered table-hover " style="width:100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tipo de Gasto</th>
                                <th>Descripcion</th>
                                <th>Costo</th>
                                <th>Fecha</th>
                                <th>Estatus</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12">
                <h3 class="titulocenter">Gastos Acumulados</h3>
                <h4><span>{{ $totalAnio }} MXN</span> Gastos del Año</h4>
                <div class="table-responsive">
                    <table id="table-gastos" class="table table-bordered table-hover " style="width:100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tipo de Gasto</th>
                                <th>Descripcion</th>
                                <th>Costo</th>
                                <th>Fecha</th>
                                <th>Estatus</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
    
    </div>
        

        <div class="floating-arriba">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modaladdgasto">
                <span data-toggle="modal" data-target="#id">
                    <a data-toggle="tooltip" data-placement="top" title="Agregar Gasto"><i class="fa fa-plus"> Agregar Gasto</i></a>
                </span>
            </button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modalatipogasto">
                <span data-toggle="modal" data-target="#id">
                    <a data-toggle="tooltip" data-placement="top" title="Agregar Gasto"><i class="fa fa-plus"> Agregar Tipo de Gasto</i></a>
                </span>
            </button>
        </div>
</section>


  <!-- Modal agregar gastos -->
  <div class="modal fade" id="Modaladdgasto" tabindex="-1" role="dialog" aria-labelledby="rutacLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rutacLabel">Agregar Vehiculo a Ruta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{ Form::open(['url' => '/gastos/', 'method' => 'POST','id' => 'gastos']) }}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Tipo de Gasto</p>
                            <select class="form-control" id="tipogasto" name="tipogasto">
                                @foreach ($tipogasto as $item)
                                    <option value="{{ $item->id }}">{{ $item->tipogasto }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Descripción</p>
                            <input id="descripcion" type="text" class="form-control" name="descripcion">
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Costo</p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="costo">$</span>
                                </div>
                                <input id="costo" type="number" class="form-control" name="costo" step="any" >
                            </div> 
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Fecha del Gasto</p>
                            <input id="fechagasto" value="" type="text" class="form-control" name="fechagasto">
                            <script>
                                var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                  $('#fechagasto').datepicker({
                                      uiLibrary: 'bootstrap4',
                                      minDate: '1940-12-31',
                                      maxDate: today,
                                      locale: 'es-es',
                                      format: 'yyyy-mm-dd',
                                  });
                            </script> 
                        </div>     
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="guardargasto">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>
  {{ Form::close() }}
  {{-- fin  Modal agregar gasto  --}}

  <!-- Modal agregar tipo gastos -->
  <div class="modal fade" id="Modalatipogasto" tabindex="-1" role="dialog" aria-labelledby="rutacLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rutacLabel">Agregar Vehiculo a Ruta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{ Form::open(['url' => '/tipogastos/', 'method' => 'POST','id' => 'tipogastos']) }}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Tipo de Gasto</p>
                            <input id="tipogastoadd" type="text" class="form-control" name="tipogastoadd">
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="guardartipogasto">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>
  {{ Form::close() }}
  {{-- fin  Modal agregar tipo de gasto  --}}

@endsection

@section('scripts')
    <script>
        $(document).on('click','#guardargasto',function(){
        var form = $('#gastos')
        var url = form.attr('action')
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
                    timer: 4000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })
                    Toast.fire({
                    icon: 'success',
                    title: 'Gasto Agregado '
                    })
                    document.location.reload();
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
                    title: 'No se pudo agregar el gasto'
                    })
                }
            }
        });
    });

    $(document).on('click','#guardartipogasto',function(){
        var form = $('#tipogastos')
        var url = form.attr('action')
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
                    title: 'Se agrego el Tipo de Gasto al Catalogo '
                    })
                    document.location.reload();
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
                    title: 'No se Agrego el Tipo de Gasto'
                    })
                }
            }
        });
    });

    $(function() {
        $('#table-gastos_mes').DataTable({
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
            ajax: '{!! route('gastos.mes.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'tipogasto', name: 'tipogasto' },
                { data: 'descripcion_gasto', name: 'descripcion_gasto' },
                { data: 'costo_gasto', name: 'costo_gasto' },
                { data: 'fecha_gasto', name: 'fecha_gasto' },
                { data: 'estatus_gasto', name: 'estatus_gasto'},
                {
                    sortable: false,
                    "width": "2%",
                    "render": function ( data, type, full, meta ) {
                     var buttonID = full.id;
                     if (full.estatus_gasto == 1) {
                        return '<button type="button" class="btn btn-outline-danger btn-block gasto-baja" value="'+buttonID+'&0"><i class="fa fa-trash" ></i></button>'
                     }else{
                        return '<button type="button" class="btn btn-outline-success btn-block gasto-baja" value="'+buttonID+'&1"><i class="fa fa-check" ></i></button>'
                     }
                    
                 }
                },
                
            ],
            columnDefs: [
                { targets: 5, "width": "2%",
                    "render": function ( data, type, row, meta ) {
                        if ( row['estatus_gasto'] == 1 ) {
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

    $(function() {
        $('#table-gastos').DataTable({
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
            ajax: '{!! route('gastos.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'tipogasto', name: 'tipogasto' },
                { data: 'descripcion_gasto', name: 'descripcion_gasto' },
                { data: 'costo_gasto', name: 'costo_gasto' },
                { data: 'fecha_gasto', name: 'fecha_gasto' },
                { data: 'estatus_gasto', name: 'estatus_gasto'},
                {
                    sortable: false,
                    "width": "2%",
                    "render": function ( data, type, full, meta ) {
                     var buttonID = full.id;
                     if( full.estatus_gasto == 1){
                        return '<button type="button" class="btn btn-outline-danger btn-block gasto-baja" value="'+buttonID+'&0"><i class="fa fa-trash" ></i></button>'
                     }else{
                        return '<button type="button" class="btn btn-outline-success btn-block gasto-baja" value="'+buttonID+'&1"><i class="fa fa-check" ></i></button>'
                     }
                    
                    
                 }
                },
                
            ],
            columnDefs: [
                { targets: 5, "width": "2%",
                    "render": function ( data, type, row, meta ) {
                        if ( row['estatus_gasto'] == 1 ) {
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

    //dar de baja gasto 
    $(document).on('click','.gasto-baja',function(){
        var id = $(this).val();
        var separar = id.split('&')
        if(separar[1] == 0){
            var url = '/gasto_baja/'+separar[0]
        }else{
            var url = '/gasto_activo/'+separar[0]
        }
        
        Swal.fire({
            title: '¿Estás seguro de realizar el cambio?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Modificar!',
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
                                    'El gasto fue Eliminado.',
                                    'success'
                                    )
                                }
                                document.location.reload();
                            }else if(data == 2){
                                if (result.value) {
                                    Swal.fire(
                                    'Reactivado!',
                                    'El gasto fue Activado.',
                                    'success'
                                    )
                                }
                                document.location.reload();
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
    </script>   
@endsection