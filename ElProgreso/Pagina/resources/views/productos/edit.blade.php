@extends("layouts.app")

@section("content")
@foreach ($producto as $productos)
    
{{ Form::open(['url' => '/productos/'.$productos->id, 'method' => 'PUT']) }}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <!-- Media middle -->
                    <div class="media">
                        <div class="media-left media-middle">
                                <img src="{{ url('/img/cookie.png')}}" class="media-object" style="width:100px">
                        </div>
                        <div class="media-body">
                        <h4 class="media-heading">{{ $productos->nombre }}</h4>
                        <p>Descripcion: {{ $productos->descripcion }}</p>
                        @if($productos->estatus_produ == 1)
                        <p>Estatus: Activo</p>
                        @else
                        <p>Estatus: Baja</p>
                        @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                        @csrf
                    <div class="form-group row">
                        <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre del Producto') }}</label>

                        <div class="col-md-6">
                            <input id="nombre" value="{{ $productos->nombre }}" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" autocomplete="name" autofocus>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción del Producto') }}</label>

                        <div class="col-md-6">
                            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="2" placeholder="Descripcion del producto">{{ $productos->descripcion }}</textarea>
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo del producto') }}</label>

                        <div class="col-md-6">
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="{{ $productos->fktipo }}">{{ $productos->nombre_produc." - ".$productos->descripcion_produc }}</option>
                                @foreach ($tipos as $item)
                                    <option value="{{ $item->id_tipo }}">{{ $item->nombre_produc." - ".$item->descripcion_produc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tipoproducto">
                            <span data-toggle="modal" data-target="#id">
                                <a data-toggle="tooltip" data-placement="top" title="añadir nuevo tipo de producto"><i class="fa fa-plus"></i></a>
                            </span>
                        </button>
                    </div>
                    <div class="form-group row">
                        <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo') }}</label>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="costo">$</span>
                                </div>
                                <input id="costo" value="{{ $productos->costo }}" type="number" step="any" class="form-control @error('costo') is-invalid @enderror" name="costo">
                                @error('costo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="precio_venta" class="col-md-4 col-form-label text-md-right">{{ __('Precio de Venta') }}</label>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="precio_venta">$</span>
                                </div>
                                <input id="precio_venta" value="{{ $productos->precio_venta }}" type="number" step="any" class="form-control @error('precio_venta') is-invalid @enderror" name="precio_venta">
                                @error('precio_venta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="precio_menudeo" class="col-md-4 col-form-label text-md-right">{{ __('Precio de Menudeo') }}</label>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="precio_menudeo">$</span>
                                </div>
                                <input id="precio_menudeo" value="{{ $productos->precio_menudeo }}" type="number" step="any" class="form-control @error('precio_menudeo') is-invalid @enderror" name="precio_menudeo">
                                @error('precio_menudeo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="precio_mayoreo" class="col-md-4 col-form-label text-md-right">{{ __('Precio de Mayoreo') }}</label>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="precio_mayoreo">$</span>
                                </div>
                                <input id="precio_mayoreo" value="{{ $productos->precio_mayoreo }}" type="number" step="any" class="form-control  @error('precio_mayoreo') is-invalid @enderror" name="precio_mayoreo">
                                @error('precio_mayoreo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cantidad" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>

                        <div class="col-md-6">
                            <input id="cantidad" type="number" value="{{ $productos->existencia }}" class="form-control @error('cantidad') is-invalid @enderror" name="cantidad" min="0" max="10000">
                            @error('cantidad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="proveedor" class="col-md-4 col-form-label text-md-right">{{ __('Proveedor') }}</label>

                        <div class="col-md-6">
                            <select class="form-control" id="proveedor" name="proveedor">
                                <option value="{{ $productos->idproveedor }}">{{ $productos->nombre_pro }}</option>
                                @foreach ($proveedores as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre_pro }}</option>
                                @endforeach
                                <option value="">
                                    
                                </option>
                            </select>
                        </div>
                        <a href="{{ url('/proveedores/create') }}">
                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="añadir nuevo proveedor">
                            <i class="fa fa-plus"></i>
                        </button>
                        </a>
                    </div>
                    <div class="form-group row">
                        <label for="fecharegistro" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Registro') }}</label>

                        <div class="col-md-6">
                            <input id="fecharegistro" value="{{ $productos->fecha_registro_prod }}" type="text" class="form-control @error('fecharegistro') is-invalid @enderror" name="fecharegistro">
                            @error('fecharegistro')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <script>
                                var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                var daymin = new Date();
                                daymin.setDate(daymin.getDate() - 4);
                                    $('#fecharegistro').datepicker({
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
                        <label for="bja" class="col-md-4 col-form-label text-md-right">{{ __('Estatus') }}</label>

                        <div class="col-md-6">
                            <select class="form-control" id="baja" name="baja">
                                @if($productos->estatus_produ == 1)
                                <option value="{{ $productos->estatus_produ }}">Activo</option>
                                <option value="2">Baja</option>
                                @else
                                <option value="{{ $productos->estatus_produ }}">Baja</option>
                                <option value="1">Activo</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fechabaja" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de la baja') }}</label>

                        <div class="col-md-6">
                            <input id="fechabaja" value="{{ $productos->fecha_baja_produ}}" type="text" class="form-control" name="fechabaja">
                            <script>
                                var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                                var daymin = new Date();
                                daymin.setDate(daymin.getDate() - 4);
                                  $('#fechabaja').datepicker({
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
                        <label for="motivobaja" class="col-md-4 col-form-label text-md-right">{{ __('Motivo de baja') }}</label>

                        <div class="col-md-6">
                            <textarea name="motivobaja" class="form-control" rows="3" placeholder="Motivo de la baja">{{ $productos->motivo_baja_produ }}</textarea>
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

{{ Form::close() }}
@endforeach
<!-- Modal -->
<div class="modal fade" id="tipoproducto" tabindex="-1" role="dialog" aria-labelledby="tipoproductoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tipoproductoLabel">Crear nuevo tipo de producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{ Form::open(['url' => '/t_productos/', 'method' => 'POST']) }}
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Tipo Producto</p>
                            <input id="nombre" type="text" class="form-control" name="nombre_tipo" placeholder="Tipo de Producto">
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Decripción</p>
                            <textarea name="des_tipo" class="form-control" rows="2" placeholder="Descripción del tipo de producto"></textarea>
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
<div class="floating">
    <a href="{{ url('/productos') }}" class="btn btn-primary btn-fab">
        <i class="fa fa-arrow-left"> Regresar</i>
    </a>
</div>
@endsection