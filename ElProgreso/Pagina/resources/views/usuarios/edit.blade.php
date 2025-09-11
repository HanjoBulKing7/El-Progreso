@extends("layouts.app")

@section("content")
<section id="team" class="pb-5">
    <div class="container">
        <h5 class="section-title h1">Editar Datos del Usuario</h5>
        {{-- @include('usuarios.form',['usuarios' => $usuarios,'url' => '/usuarios/'.$usuarios->id,'method'=>'PUT']) --}}
        <form action="{{ url('/usuarios/'. $usuarios->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <!-- Media middle -->
                    <div class="media">

                            @if($usuarios->urlfoto != '')
                                <img src="{{ url("img/".$usuarios->id.".".$usuarios->urlfoto)}}" class="align-self-center mr-3" style="width:200px">
                            @else
                                <img src="{{ url('/img/user_login.png')}}" class="align-self-center mr-3" style="width:100px">
                            @endif

                        <div class="media-body">
                            <h4 class="media-heading">{{ $usuarios->name." ".$usuarios->apepat." ".$usuarios->apemat }}</h4>
                            @if($usuarios->fktiporol == 1)
                            <p>Puesto: Administrador</p>
                            @else
                            <p>Puesto: Chofer</p>
                            @endif

                            @if($usuarios->estatus == 1)
                            <p>Estatus: Activo</p>
                            @else
                            <p>Estatus: Baja</p>
                            @endif
                            @foreach ($licencia as $lic)
                            <p>Licencia: <b>{{ $lic->no_licencia}}</b> , Expedida: <b>{{ $lic->fecha_exp }}</b>, Vencimiento: <b>{{ $lic->fecha_ven }}</b></p>
                            <input type="hidden" id="lic_vencimineto" value="{{ $lic->fecha_ven }}">
                            @endforeach

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#licencia">Agregar Licencia</button>

                        </div>
                    </div>
                    {{-- fin media middle --}}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" value="{{ $usuarios->name }}" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

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
                                <input id="email" value="{{ $usuarios->email }}" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

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
                            <label for="salario" class="col-md-4 col-form-label text-md-right">{{ __('Salario') }}</label>

                            <div class="col-md-6">
                                <input id="salario" value="{{ $usuarios->salario }}" type="text" class="form-control" name="salario">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="salario" class="col-md-4 col-form-label text-md-right">{{ __('Infonavit') }}</label>

                            <div class="col-md-6">
                                <input id="infonavit" value="{{ $usuarios->infonavit }}" type="text" class="form-control" name="infonavit">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="puesto" class="col-md-4 col-form-label text-md-right">{{ __('Puesto') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" id="puesto" name="puesto">
                                    @foreach ($estatus as $item)
                                        <option value="{{ $item->id_rol }}">{{ $item->rol }}</option>
                                    @endforeach
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id_rol }}">{{ $rol->rol }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fechaingreso" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Ingreso') }}</label>

                            <div class="col-md-6">
                                <input id="fechaingreso" value="{{ $usuarios->fecha_ingreso}}" type="text" class="form-control" name="fechaingreso">
                                <script>
                                    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                    var daymin = new Date();
                                    daymin.setDate(daymin.getDate() - 10);
                                      $('#fechaingreso').datepicker({
                                          uiLibrary: 'bootstrap4',
                                          minDate: daymin,
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
                                    <label class="custom-file-label" for="fileToUpload">Adjuntar Foto</label>
                                </div>
                            </div>
                        </div>
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
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bja" class="col-md-4 col-form-label text-md-right">{{ __('Estatus') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" id="baja" name="baja">
                                    @if($usuarios->estatus == 1)
                                    <option value="{{ $usuarios->estatus }}">Activo</option>
                                    <option value="2">Baja</option>
                                    @else
                                    <option value="{{ $usuarios->estatus }}">Baja</option>
                                    <option value="1">Activo</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fechabaja" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de la baja') }}</label>

                            <div class="col-md-6">
                                <input id="fechabaja" value="{{ $usuarios->fecha_baja}}" type="text" class="form-control" name="fechabaja">
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
                        </div>
                        <div class="form-group row">
                            <label for="motivobaja" class="col-md-4 col-form-label text-md-right">{{ __('Motivo de baja') }}</label>

                            <div class="col-md-6">
                                <textarea name="motivobaja" class="form-control" rows="3" placeholder="Motivo de la baja">{{ $usuarios->motivo_baja }}</textarea>
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

        </form>>

        <form action="{{ url('/usuarios/'. $usuarios->id) }}" method="POST" class="inline-block">
            @method('DELETE')
            @csrf
            <input type="submit" class="btn btn-link red-text no-padding no-margin no-transform" value="Eliminar" >
        </form>

    </div>
    <div class="floating">
		<a href="{{ url('/usuarios') }}" class="btn btn-primary btn-fab">
			<i class="fa fa-arrow-left"> Regresar</i>
		</a>
    </div>

    <!-- Modal -->
<div class="modal fade" id="licencia" tabindex="-1" role="dialog" aria-labelledby="licenciaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="licenciaLabel">Crear nuevo tipo de producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/licencias') }}" method="POST">
                @csrf
                <input type="hidden" name="id_usuario" value="{{ $usuarios->id }}">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Numero de licencia</p>
                            <input id="nolicencia" type="text" class="form-control @error('nolicencia') is-invalid @enderror" name="nolicencia" placeholder="licencia" maxlength="11">
                                @error('nolicencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Fecha de expedición</p>
                            <input id="licenexpedida" value="{{ $usuarios->fecha_baja}}" type="text" class="form-control @error('licenexpedida') is-invalid @enderror" name="licenexpedida">
                            <script>
                                var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

                                    $('#licenexpedida').datepicker({
                                        uiLibrary: 'bootstrap4',
                                        minDate: '1940-12-31',
                                        maxDate: today,
                                        locale: 'es-es',
                                        format: 'yyyy-mm-dd',
                                    });
                            </script>

                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Fecha de Vencimiento</p>
                            <input id="licenvenci" value="{{ $usuarios->fecha_baja}}" type="text" class="form-control @error('licenvenci') is-invalid @enderror" name="licenvenci">
                            <script>
                                var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

                                    $('#licenvenci').datepicker({
                                        uiLibrary: 'bootstrap4',
                                        minDate: '1940-12-31',
                                        maxDate: '2050-12-31',
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
          <button type="submit" class="btn btn-primary">Guardar Licencia</button>
        </div>
      </div>
    </div>
  </div>
  {{-- fin modal  --}}

</section>




@endsection
@section('scripts')
  <!--para poner el nombre del documento seleccionado en el text area-->
  <script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
<script>
    $(document).ready(function(){
        var fechavenci = $('#lic_vencimineto').val();
        fechavenci = new Date(fechavenci);

        var fecha = $('#lic_vencimineto').val();
        var fecha = new Date(fecha);
        fecha.setDate(fecha.getDate() + 30);

        var daymin = new Date();

        var fechaimp = fechavenci - daymin;
        fechaimp = Math.round(fechaimp/(1000*60*60*24))

        if(fecha >= daymin && fechaimp < 30){
            let timerInterval
            Swal.fire({
            icon: 'warning',
            title: 'Licencia esta por expirar!',
            html: 'Dias para vencimiento: '+ fechaimp,
            timer: 4000,
            timerProgressBar: true,
            onBeforeOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                    b.textContent = Swal.getTimerLeft()
                    }
                }
                }, 100)
            },
            onClose: () => {
                clearInterval(timerInterval)
            }
            })
        }





    })
</script>
@endsection
