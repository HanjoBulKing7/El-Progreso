@extends("layouts.app")

@section("content")


{{ Form::open(['url' => '/productos/', 'method' => 'POST']) }}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p>Pagina de Alta Productos</p>
                </div>

                <div class="card-body">
                        @csrf

                    <div class="form-group row">
                        <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre del Producto') }}</label>

                        <div class="col-md-6">
                            <input id="nombre" type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" autofocus>
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
                            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="2" placeholder="Descripcion del producto"></textarea>
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
                                <input id="costo" type="number" class="form-control @error('costo') is-invalid @enderror" name="costo" step="any">
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
                                <input id="precio_venta" type="number" class="form-control @error('precio_venta') is-invalid @enderror" name="precio_venta" step="any" >
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
                                <input id="precio_menudeo" type="number" class="form-control  @error('precio_menudeo') is-invalid @enderror" name="precio_menudeo" step="any" >
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
                                <input id="precio_mayoreo" type="number" class="form-control  @error('precio_mayoreo') is-invalid @enderror" name="precio_mayoreo" step="any" >
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
                            <input id="cantidad" type="number" class="form-control  @error('cantidad') is-invalid @enderror" name="cantidad" min="0" max="10000">
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
                                @foreach ($proveedores as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre_pro }}</option>
                                @endforeach
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
                            <input id="fecharegistro" type="text" class="form-control @error('fecharegistro') is-invalid @enderror" name="fecharegistro">
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
                            <input id="nombre_tipo" type="text" class="form-control @error('nombre_tipo') is-invalid @enderror" name="nombre_tipo" placeholder="Tipo de Producto">
                            @error('nombre_tipo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 col-xs-12 col-lg-12">
                            <p>Decripción</p>
                            <textarea name="des_tipo" class="form-control @error('des_tipo') is-invalid @enderror" rows="2" placeholder="Descripción del tipo de producto"></textarea>
                            @error('des_tipo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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