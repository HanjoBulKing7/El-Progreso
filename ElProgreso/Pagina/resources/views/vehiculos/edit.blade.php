@extends("layouts.app")

@section("content")

    <form action="{{ url('/vehiculos/' . $vehiculo->id) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- Media middle -->
                            <div class="media">
                                <div class="media-left media-middle">
                                    <img src="{{ url('/img/pickup-2.png')}}" class="media-object" style="width:100px">
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{{ $vehiculo->marca_veh."-".$vehiculo->modelo_veh }}</h4>
                                    <p>Telefono del Seguro: {{ $vehiculo->tel_seg_veh }}</p>
                                    @if($vehiculo->estatus_veh == 1)
                                        <p>Estatus: Activo</p>
                                    @else
                                        <p>Estatus: Baja</p>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="nombre_vehiculo"
                                           class="col-md-4 col-form-label text-md-right">{{ __('ID Vehiculo') }}</label>

                                    <div class="col-md-6">
                                        <input id="nombre_vehiculo" type="text" value="{{ $vehiculo->vehiculo }}"
                                               class="form-control @error('nombre_vehiculo') is-invalid @enderror"
                                               name="nombre_vehiculo" autocomplete="name" autofocus>
                                        @error('nombre_vehiculo')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="marca"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Marca') }}</label>

                                    <div class="col-md-6">
                                        <input id="marca" type="text" value="{{ $vehiculo->marca_veh }}"
                                               class="form-control @error('marca') is-invalid @enderror" name="marca">
                                        @error('marca')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="modelo"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }}</label>

                                    <div class="col-md-6">
                                        <input id="modelo" value="{{ $vehiculo->modelo_veh }}" type="text"
                                               class="form-control @error('modelo') is-invalid @enderror" name="modelo">
                                        @error('modelo')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="placas"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Placas') }}</label>

                                    <div class="col-md-6">
                                        <input id="placas" value="{{ $vehiculo->placas_veh }}" type="text"
                                               class="form-control @error('placas') is-invalid @enderror" name="placas">
                                        @error('placas')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="descripcion"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }}</label>

                                    <div class="col-md-6">
                                        <textarea name="descripcion" class="form-control" rows="2"
                                                  placeholder="Descripcion del vehiculo">{{ $vehiculo->desc_veh }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="correo"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Poliza') }}</label>

                                    <div class="col-md-6">
                                        <input id="poliza" value="{{ $vehiculo->poliza_veh }}" type="text"
                                               class="form-control @error('poliza') is-invalid @enderror" name="poliza">
                                        @error('poliza')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tel_seguro"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Telefono de Seguro') }}</label>

                                    <div class="col-md-6">
                                        <input id="tel_seguro" value="{{ $vehiculo->tel_seg_veh }}" type="text"
                                               class="form-control" name="tel_seguro">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fechaalta"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Fecha de alta') }}</label>

                                    <div class="col-md-6">
                                        <input id="fechaalta" value="{{ $vehiculo->fecha_alta_veh }}" type="text"
                                               class="form-control" name="fechaalta">
                                        <script>
                                            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                            console.log(today)
                                            $('#fechaalta').datepicker({
                                                uiLibrary: 'bootstrap4',
                                                minDate: today,
                                                maxDate: today,
                                                locale: 'es-es',
                                                format: 'yyyy-mm-dd',
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fechacompra"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Fecha de compra') }}</label>

                                    <div class="col-md-6">
                                        <input id="fechacompra" value="{{ $vehiculo->fecha_com_veh }}" type="text"
                                               class="form-control" name="fechacompra">
                                        <script>
                                            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                            console.log(today)
                                            $('#fechacompra').datepicker({
                                                uiLibrary: 'bootstrap4',
                                                minDate: '1940-12-31',
                                                maxDate: today,
                                                locale: 'es-es',
                                                format: 'yyyy-mm-dd',
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inicioseg"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio del seguro') }}</label>

                                    <div class="col-md-6">
                                        <input id="inicioseg" type="text" value="{{ $vehiculo->inicio_seg_veh }}"
                                               class="form-control" name="inicioseg">
                                        <script>
                                            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                            console.log(today)
                                            $('#inicioseg').datepicker({
                                                uiLibrary: 'bootstrap4',
                                                minDate: '1940-12-31',
                                                maxDate: '2025-12-31',
                                                locale: 'es-es',
                                                format: 'yyyy-mm-dd',
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="finseguro"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Fin del Seguro') }}</label>

                                    <div class="col-md-6">
                                        <input id="finseguro" value="{{ $vehiculo->fin_seg_veh }}" type="text"
                                               class="form-control" name="finseguro">
                                        <script>
                                            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                            console.log(today)
                                            $('#finseguro').datepicker({
                                                uiLibrary: 'bootstrap4',
                                                minDate: '1940-12-31',
                                                maxDate: '2025-12-31',
                                                locale: 'es-es',
                                                format: 'yyyy-mm-dd',
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kilometro"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Kilometraje Actual') }}</label>

                                    <div class="col-md-6">
                                        <input id="kilometro" value="{{ $vehiculo->km_actual_veh }}" type="text"
                                               class="form-control" name="kilometro">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="baja"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Estatus') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="baja" name="baja">
                                            @if($vehiculo->estatus_veh == 1)
                                                <option value="{{ $vehiculo->estatus_veh }}">Activo</option>
                                                <option value="0">Baja</option>
                                            @else
                                                <option value="{{ $vehiculo->estatus_veh }}">Baja</option>
                                                <option value="1">Activo</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fechabaja"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Fin del Seguro') }}</label>

                                    <div class="col-md-6">
                                        <input id="fechabaja" value="{{ $vehiculo->fecha_baja_veh }}" type="text"
                                               class="form-control" name="fechabaja">
                                        <script>
                                            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                            console.log(today)
                                            $('#fechabaja').datepicker({
                                                uiLibrary: 'bootstrap4',
                                                minDate: '1940-12-31',
                                                maxDate: today,
                                                locale: 'es-es',
                                                format: 'yyyy-mm-dd',
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="motivobaja"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }}</label>

                                    <div class="col-md-6">
                                        <textarea name="motivobaja" class="form-control" rows="2"
                                                  placeholder="Motivo de Baja del vehiculo">{{ $vehiculo->motivo_baja_veh }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-outline-primary btn-block">
                                            {{ __('Guardar') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="floating">
                <a href="{{ url('/vehiculos') }}" class="btn btn-primary btn-fab">
                    <i class="fa fa-arrow-left"> Regresar</i>
                </a>
            </div>
        </div>
    </form>
@endsection
