@extends("layouts.app")

@section("content")

    <form action="{{ url('/vehiculos') }}" method="POST">
        @csrf
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <p>Pagina de Alta de Vehiculos</p>
                        </div>

                        <div class="card-body">

                            <div class="form-group row">
                                <label for="nombre_vehiculo"
                                       class="col-md-4 col-form-label text-md-right">{{ __('ID Vehiculo') }}</label>

                                <div class="col-md-6">
                                    <input id="nombre_vehiculo" type="text"
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
                                    <input id="marca" type="text"
                                           class="form-control @error('marca') is-invalid @enderror" name="marca"
                                           autocomplete="name" autofocus>
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
                                    <input id="modelo" type="text"
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
                                    <input id="placas" type="text"
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
                                              placeholder="Descripcion del vehiculo"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="correo"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Poliza') }}</label>

                                <div class="col-md-6">
                                    <input id="poliza" type="text"
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
                                    <input id="tel_seguro" type="text" class="form-control" name="tel_seguro">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fechaalta"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Fecha de alta') }}</label>

                                <div class="col-md-6">
                                    <input id="fechaalta" type="text" class="form-control" name="fechaalta">
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
                                    <input id="fechacompra" type="text" class="form-control" name="fechacompra">
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
                                    <input id="inicioseg" type="text" class="form-control" name="inicioseg">
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
                                    <input id="finseguro" type="text" class="form-control" name="finseguro">
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
                                    <input id="kilometro" type="text" class="form-control" name="kilometro">
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

    </form>>
    <div class="floating">
        <a href="{{ url('/vehiculos') }}" class="btn btn-primary btn-fab">
            <i class="fa fa-arrow-left"> Regresar</i>
        </a>
    </div>
@endsection
