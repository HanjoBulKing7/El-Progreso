@extends("layouts.app")

@section("content")

    <form action="{{ url('/proveedores/' . $proveedor->id) }}" method="POST">
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
                                <img src="{{ url('/img/user_login.png')}}" class="media-object" style="width:100px">
                        </div>
                        <div class="media-body">
                        <h4 class="media-heading">{{ $proveedor->nombre_pro." ".$proveedor->apepat_pro." ".$proveedor->apemat_pro }}</h4>
                        <p>Telefono: {{ $proveedor->telefono_pro }}</p>
                        @if($proveedor->estatus_pro == 1)
                        <p>Estatus: Activo</p>
                        @else
                        <p>Estatus: Baja</p>
                        @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="nombre_prove" value="{{ $proveedor->nombre_pro }}" type="text" class="form-control @error('nombre_prove') is-invalid @enderror" name="nombre_prove"  autocomplete="name" autofocus>
                                @error('nombre_prove')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="apepat" class="col-md-4 col-form-label text-md-right">{{ __('Apellido Paterno') }}</label>

                            <div class="col-md-6">
                                <input id="apepat" value="{{ $proveedor->apepat_pro }}" type="text" class="form-control @error('apepat') is-invalid @enderror" name="apepat">
                                @error('apepat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apemat" class="col-md-4 col-form-label text-md-right">{{ __('Apellido Materno') }}</label>

                            <div class="col-md-6">
                                <input id="apemat" value="{{ $proveedor->apemat_pro }}" type="text" class="form-control" name="apemat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="correo" class="col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>

                            <div class="col-md-6">
                                <input id="correo" value="{{ $proveedor->email_pro }}" type="email" class="form-control" name="correo"  autocomplete="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="direccion" class="col-md-4 col-form-label text-md-right">{{ __('Direccion') }}</label>

                            <div class="col-md-6">
                                <input id="direccion" value="{{ $proveedor->direccion_pro }}" type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion">
                                @error('direccion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

                            <div class="col-md-6">
                                <input id="telefono" value="{{ $proveedor->telefono_pro }}" type="text" class="form-control" name="telefono">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fecharegistro" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Ingreso') }}</label>

                            <div class="col-md-6">
                                <input id="fecharegistro" value="{{ $proveedor->fecha_ingreso_pro}}" type="text" class="form-control @error('fecharegistro') is-invalid @enderror" name="fecharegistro">
                                @error('fecharegistro')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <script>
                                    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                      $('#fecharegistro').datepicker({
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
                            <label for="baja" class="col-md-4 col-form-label text-md-right">{{ __('Estatus') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="baja" name="baja">
                                    @if($proveedor->estatus_pro == 1)
                                    <option value="{{ $proveedor->estatus_pro }}">Activo</option>
                                    <option value="2">Baja</option>
                                    @else
                                    <option value="{{ $proveedor->estatus_pro }}">Baja</option>
                                    <option value="1">Activo</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fechabaja" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de la baja') }}</label>

                            <div class="col-md-6">
                                <input id="fechabaja" value="{{ $proveedor->fecha_baja_pro}}" type="text" class="form-control" name="fechabaja">
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
                            <label for="motivobaja" class="col-md-4 col-form-label text-md-right">{{ __('Motivo de baja') }}</label>

                            <div class="col-md-6">
                                <textarea name="motivobaja" class="form-control" rows="3" placeholder="Motivo de la baja">{{ $proveedor->motivo_baja_pro }}</textarea>
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-primary btn-block">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>
                    </form>
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
