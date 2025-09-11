@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Registro') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="apepat" class="col-md-4 col-form-label text-md-right">{{ __('Apellido Paterno') }}</label>

                            <div class="col-md-6">
                                <input id="apepat" type="text" class="form-control" name="apepat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apemat" class="col-md-4 col-form-label text-md-right">{{ __('Apellido Materno') }}</label>

                            <div class="col-md-6">
                                <input id="apemat" type="text" class="form-control" name="apemat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="direccion" class="col-md-4 col-form-label text-md-right">{{ __('Direccion') }}</label>

                            <div class="col-md-6">
                                <input id="direccion" type="text" class="form-control" name="direccion">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control" name="telefono">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="salario" class="col-md-4 col-form-label text-md-right">{{ __('Salario') }}</label>

                            <div class="col-md-6">
                                <input id="salario" type="text" class="form-control" name="salario">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="salario" class="col-md-4 col-form-label text-md-right">{{ __('Infonavit') }}</label>

                            <div class="col-md-6">
                                <input id="infonavit" type="text" class="form-control" name="infonavit">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="puesto" class="col-md-4 col-form-label text-md-right">{{ __('Puesto') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" id="puesto" name="puesto">
                                    <option value="1">Administrador</option>
                                    <option value="2">Chofer</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fechaingreso" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Ingreso') }}</label>

                            <div class="col-md-6">
                                <input id="fechaingreso" type="text" class="form-control" name="fechaingreso">
                                <script>
                                    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                      $('#fechaingreso').datepicker({
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
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de nacimiento') }}</label>

                            <div class="col-md-6">
                                <input id="fechanacimiento" type="text" class="form-control" name="fechanacimiento">
                                <script>
                                    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                    console.log(today)
                                      $('#fechanacimiento').datepicker({
                                          uiLibrary: 'bootstrap4',
                                          minDate: '1940-12-31',
                                          maxDate: today,
                                          locale: 'es-es',
                                          format: 'yyyy-mm-dd',
                                      });
                                </script>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="fileToUpload" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" >
                                    <label class="custom-file-label" for="fileToUpload">Adjuntar Documento</label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-primary btn-block">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="floating">
    <a href="{{ url('/usuarios') }}" class="btn btn-primary btn-fab">
        <i class="fa fa-arrow-left"> Regresar</i>
    </a>
</div>
@endsection

@section('scripts')
  <!--para poner el nombre del documento seleccionado en el text area-->
  {{-- <script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script> --}}
@endsection
