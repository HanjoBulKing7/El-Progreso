{{ Form::open(['url' => $url, 'method' => $method, 'files' => true, 'enctype' => 'multipart/form-data']) }}

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
                                <input id="name" value="{{ $usuarios->name }}" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                <input id="email" value="{{ $usuarios->email }}" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="apepat" value="{{ $usuarios->apepat }}" type="text" class="form-control" name="apepat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apemat" class="col-md-4 col-form-label text-md-right">{{ __('Apellido Materno') }}</label>

                            <div class="col-md-6">
                                <input id="apemat" value="{{ $usuarios->apemat }}" type="text" class="form-control" name="apemat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="direccion" class="col-md-4 col-form-label text-md-right">{{ __('Direccion') }}</label>

                            <div class="col-md-6">
                                <input id="direccion" value="{{ $usuarios->direccion }}" type="text" class="form-control" name="direccion">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

                            <div class="col-md-6">
                                <input id="telefono" value="{{ $usuarios->telefono }}" type="text" class="form-control" name="telefono">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="puesto" class="col-md-4 col-form-label text-md-right">{{ __('Puesto') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" id="puesto" name="puesto">
                                    <option value="{{ $usuarios->fktiporol }}">Hola</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Chofer</option>
                                    <option value="3">Gerente</option>
                                    <option value="4">Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fechaingreso" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Ingreso') }}</label>

                            <div class="col-md-6">
                                <input id="fechaingreso" value="{{ $usuarios->fecha_ingreso}}" type="text" class="form-control" name="fechaingreso">
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
                                <input id="fechanacimiento" value="{{ $usuarios->fecha_nacimiento}}" type="text" class="form-control" name="fechanacimiento">
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
                        <div class="form-group row">
                            <label for="fileToUpload" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" >
                                    <label class="custom-file-label" for="fileToUpload">Adjuntar Documento</label>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

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


{{ Form::close() }}