@extends("layouts.app")

@section("content")

    <form action="{{ url('/proveedores') }}" method="POST">
        @csrf

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <p>Pagina de Alta para proveedores</p>
                        </div>

                        <div class="card-body">
                            @csrf

                            <div class="form-group row">
                                <label for="nombre"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Nombre del Proveedor') }}</label>

                                <div class="col-md-6">
                                    <input id="nombre_prove" type="text"
                                           class="form-control @error('nombre_prove') is-invalid @enderror"
                                           name="nombre_prove" autocomplete="name" autofocus>
                                    @error('nombre_prove')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apepat"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Apellido Paterno') }}</label>

                                <div class="col-md-6">
                                    <input id="apepat" type="text"
                                           class="form-control @error('apepat') is-invalid @enderror" name="apepat">
                                    @error('apepat')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apemat"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Apellido Materno') }}</label>

                                <div class="col-md-6">
                                    <input id="apemat" type="text" class="form-control" name="apemat">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="correo"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>

                                <div class="col-md-6">
                                    <input id="correo" type="email" class="form-control" name="correo"
                                           autocomplete="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="direccion"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Direccion') }}</label>

                                <div class="col-md-6">
                                    <input id="direccion" type="text"
                                           class="form-control @error('direccion') is-invalid @enderror"
                                           name="direccion">
                                    @error('direccion')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telefono"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

                                <div class="col-md-6">
                                    <input id="telefono" type="text" class="form-control" name="telefono">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fecharegistro"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Registro') }}</label>

                                <div class="col-md-6">
                                    <input id="fecharegistro" type="text"
                                           class="form-control @error('fecharegistro') is-invalid @enderror"
                                           name="fecharegistro">
                                    @error('fecharegistro')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                    <script>
                                        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                        $('#fecharegistro').datepicker({
                                            uiLibrary: 'bootstrap4',
                                            minDate: today,
                                            maxDate: today,
                                            locale: 'es-es',
                                            format: 'yyyy-mm-dd',
                                        });
                                    </script>
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

    </form>
    <div class="floating">
        <a href="{{ url('/proveedores') }}" class="btn btn-primary btn-fab">
            <i class="fa fa-arrow-left"> Regresar</i>
        </a>
    </div>
@endsection
