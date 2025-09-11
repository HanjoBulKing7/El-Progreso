@extends('layouts.app')

@section('content')

    <section id="team" class="pb-5">
        <div class="container">
            <h5 class="section-title h1">Vehiculos</h5>
        </div>
        <div class="margenes">
            <div class="table-responsive">
                @csrf
                <table id="tabla-vehiculo" class="table table-bordered table-hover " style="width:100%">
                    <thead>
                    <tr>
                        <th>Vehiculo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Placas</th>
                        <th>Poliza</th>
                        <th>Telefono del Seguro</th>
                        <th>Descripción</th>
                        <th>Kilometraje</th>
                        <th>Estatus</th>
                        <th>Accion</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="floating-arriba">
            <a href="{{ url('/vehiculos/create') }}" class="btn btn-primary btn-fab">
                <i class="fa fa-user-plus"> Agregar Vehiculo</i>
            </a>
        </div>


        <!-- Modal registro km-->
        <div class="modal fade" id="Modalregistrokm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rutacLabel">Registro de Kilometraje</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/registrokm') }}" method="POST" id="formguardarkm">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-lg-12">
                                        <p>Vehiculo</p>
                                        <input id="vehiculokm" type="text" class="form-control" name="vehiculokm"
                                               disabled>
                                        <input type="hidden" id="idhiddidvehiculo" name="idhiddidvehiculo">
                                    </div>
                                    <div class="col-md-12 col-xs-12 col-lg-12">
                                        <p>Km Actual</p>
                                        <input id="kmactual" type="text" class="form-control" name="kmactual">
                                    </div>
                                    <div class="col-md-12 col-xs-12 col-lg-12">
                                        <p>Km nuevo</p>
                                        <input id="kmnuevo" type="text" class="form-control" name="kmnuevo">
                                    </div>
                                    <div class="col-md-12 col-xs-12 col-lg-12">
                                        <p>Fecha de registro</p>
                                        <input id="fechareg" value="" type="text" class="form-control" name="fechareg">
                                        <script>
                                            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                            $('#fechareg').datepicker({
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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="kmguardar">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- fin modal reistro km--}}



        <!-- Modal check semanal-->
        <div class="modal fade" id="Modalchecksemanal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rutacLabel">Checklist Semanal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/pdfchecklist') }}" method="GET" id="pdfchecklist">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-lg-6 col-sm-12">
                                        <input type="text" class="form-control" name="fecha" id="fechapdf">
                                        <script>
                                            $('#fechapdf').datepicker({
                                                uiLibrary: 'bootstrap4',
                                                locale: 'es-es',
                                                format: 'yyyy-mm-dd',
                                            });
                                        </script>
                                        <input type="hidden" id="idhiddidvehiculonom_pdf" name="vehiculo">
                                    </div>
                                    <div class="col-md-12 col-xs-12 col-lg-6 col-sm-12">
                                        <button id="consultarpdf" class="btn btn-outline-primary btn-block "
                                                type="submit">Consultar Reporte
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </form>
                        <form action="{{ url('/checklist') }}" method="POST" id="formchecklist">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-lg-12">
                                        <p>Vehiculo</p>
                                        <input id="vehiculonom" type="text" class="form-control" name="vehiculonom"
                                               disabled>
                                        <input type="hidden" id="idhiddidvehiculonom" name="idhiddidvehiculonom">
                                    </div>
                                    <div class="col-md-12 col-xs-12 col-lg-12">
                                        <table class="table">
                                            <thead>
                                            <th>Aspecto</th>
                                            <th>Buen estado</th>
                                            <th>Falta mnto</th>
                                            <th>Observaciones</th>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th>Aceite</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" value="bien" class="form-check-input"
                                                                   name="optaceite">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" value="mtto" class="form-check-input"
                                                                   name="optaceite">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentaceite"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Aceite de Direccion</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optdireccion">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optdireccion">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentdireccion"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Anticongelante</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optanti">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optanti">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentanticon"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Liquido Frenos/Clutch</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optliquido">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optliquido">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentliquido"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Tanques de Gasolina</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optgasolina">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optgasolina">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentgasolina"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Luces Altas/Bajas</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optluces">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optluces">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentluces"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Stop</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optstop">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optstop">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentstop"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Reversa</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optreversa">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optreversa">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentreversa"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Direcciones/Intermitentes</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optinter">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optinter">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentinter"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Cuartos</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optcuartos">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optcuartos">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentcuartos"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Manijas</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optmanijas">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optmanijas">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentmanijas"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Espejos</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optespejos">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optespejos">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentespejos"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Facias</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optfacias">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optfacias">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentfacias"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>LLantas</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optllantas">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optllantas">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentllantas"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Revisión de refacciones</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optrefacc">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optrefacc">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentrefacc"></textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Otro</th>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="bien"
                                                                   name="optotro">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="mtto"
                                                                   name="optotro">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><textarea class="form-control" rows="2"
                                                              name="comentotro"></textarea></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="checklistguardar">Guardar Registro</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- fin modal check semanal--}}
    </section>

@endsection

@section('scripts')
    <script>

        $(document).ready(function () {
            var url = '/obtenervehi'
            var mes = new Date().getMonth() + 1
            var mes2 = mes + 6
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                success: function (data) {
                    let vehiculos = ''
                    for (let i = 0; i < data.length; i++) {
                        if (mes == 1 || mes2 == 7) {
                            if (1 == (data[i]['placas_veh']).substr(-1) || 2 == (data[i]['placas_veh']).substr(-1)) {
                                vehiculos = vehiculos + data[i]['vehiculo'] + ', '
                            }
                        } else if (mes == 2 || mes2 == 8) {
                            if (3 == (data[i]['placas_veh']).substr(-1) || 4 == (data[i]['placas_veh']).substr(-1)) {
                                vehiculos = vehiculos + data[i]['vehiculo'] + ', '
                            }
                        } else if (mes == 3 || mes2 == 6) {
                            if (5 == (data[i]['placas_veh']).substr(-1) || 6 == (data[i]['placas_veh']).substr(-1)) {
                                vehiculos = vehiculos + data[i]['vehiculo'] + ', '
                            }
                        } else if (mes == 4 || mes2 == 10) {
                            if (7 == (data[i]['placas_veh']).substr(-1) || 8 == (data[i]['placas_veh']).substr(-1)) {
                                vehiculos = vehiculos + data[i]['vehiculo'] + ', '
                            }
                        } else if (mes == 5 || mes2 == 11) {
                            if (9 == (data[i]['placas_veh']).substr(-1) || 0 == (data[i]['placas_veh']).substr(-1)) {
                                vehiculos = vehiculos + data[i]['vehiculo'] + ', '
                            }
                        }
                    }
                    vehiculos = vehiculos.slice(0, -2)
                    Swal.fire({
                        icon: 'warning',
                        title: 'Mes de verificacion para:',
                        text: vehiculos,
                    })

                }

            });
        });

        $(function () {
            $('#tabla-vehiculo').DataTable({
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
                ajax: '{!! route('vehiculo.data') !!}',
                columns: [
                    {data: 'vehiculo', name: 'vehiculo'},
                    {data: 'marca_veh', name: 'marca_veh'},
                    {data: 'modelo_veh', name: 'modelo_veh'},
                    {data: 'placas_veh', name: 'placas_veh'},
                    {data: 'poliza_veh', name: 'poliza_veh'},
                    {data: 'tel_seg_veh', name: 'tel_seg_veh'},
                    {data: 'desc_veh', name: 'desc_veh'},
                    {data: 'km_actual_veh', name: 'km_actual_veh'},
                    {data: 'estatus_veh', name: 'estatus_veh'},
                    {
                        sortable: false,
                        "render": function (data, type, full, meta) {
                            var buttonID = full.id;
                            if (full.estatus_veh == 0) {
                                return '<a href="/vehiculos/' + buttonID + '/edit" class="btn btn-outline-primary ">Editar</a>';
                            } else {
                                return '<a href="/vehiculos/' + buttonID + '/edit" class="btn btn-outline-primary ">Editar</a> <button type="button" class="btn btn-outline-success btn-km" value="' + buttonID + '"><i class="fa fa-area-chart"></i></button> <button type="button" class="btn btn-outline-warning btn-check" value="' + buttonID + '"><i class="fa fa-list-alt"></i></button>';
                            }

                        }
                    },

                ],
                columnDefs: [
                    {
                        targets: 8, "width": "2%",
                        "render": function (data, type, row, meta) {
                            if (row['estatus_veh'] == 1) {
                                return 'Activo';
                            } else {
                                return 'Baja'
                            }
                        }
                    }
                ],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                order: [[0, "asc"]],
                "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "todos"]],
            });
        });

        //abrir modal para el registro de gasolina
        $(document).on('click', '.btn-km', function () {
            var id = $(this).val();
            var url = '/buscarvehiculo/' + id
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                success: function (data) {
                    $('#vehiculokm').val(data.vehiculo)
                    $('#idhiddidvehiculo').val(data.id)
                    $('#kmactual').val(data.km_actual_veh)
                    $("#Modalregistrokm").modal()
                }
            });
        });

        //abrir modal para el checklist semanal
        $(document).on('click', '.btn-check', function () {
            var id = $(this).val();
            var url = '/buscarvehiculo/' + id
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                success: function (data) {
                    $('#vehiculonom').val(data.vehiculo)
                    $('#idhiddidvehiculonom').val(data.id)
                    $("#Modalchecksemanal").modal()
                }
            });
        });

        $(document).on('click', '#checklistguardar', () => {
            var form = $('#formchecklist')
            var url = form.attr('action');
            var data = form.serialize()
            $.ajax({
                url: url,
                type: "post",
                data: data,
                dataType: "html",
                success: function (data) {
                    if (data == 1) {
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
                            title: 'Inspeccion Realizada'
                        })
                        $('#Modalchecksemanal').modal('hide')
                        $('#formchecklist').trigger("reset");
                    } else if (data == 2) {
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
                            title: 'Problemas al encontrat el vehiculo'
                        })
                    }
                },
                error: function (){
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
                            title: 'Problema en el servidor de BD'
                        })
                }
            })
        })
        $(document).on('click', '#kmguardar', function () {
            var id = $('#idhiddidvehiculo').val()
            var form = $('#formguardarkm')
            var url = form.attr('action');
            var data = form.serialize()

            $.ajax({
                url: url,
                type: "post",
                data: data,
                dataType: "html",
                success: function (data) {
                    if (data == 1) {
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
                            title: 'Kilometros Actualizados'
                        })
                        $('#tabla-vehiculo').DataTable().ajax.reload();
                        $('#Modalregistrokm').modal('hide')
                        $('#kmnuevo').val("")
                        $('#fechareg').val("")
                    } else if (data == 2) {
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
                            title: 'El kilometraje nuevo debe ser mayor al actual'
                        })
                    } else {
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
                            title: 'No se actualizo el kilometraje (datos incompletos)'
                        })
                    }
                }
            });
        });
    </script>

@endsection
