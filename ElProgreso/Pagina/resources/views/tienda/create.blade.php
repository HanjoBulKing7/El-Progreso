@extends("layouts.app")

@section("content")


{{ Form::open(['url' => '/tiendas/', 'method' => 'POST','id' => 'coloniaform','autocomplete'=>'off']) }}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p>Pagina de Alta Tienda</p>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <label for="nombretienda" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de la Tienda') }}</label>

                        <div class="col-md-6">
                            <input id="nombretienda" type="text" class="form-control  @error('nombretienda') is-invalid @enderror" name="nombretienda" autofocus>
                            @error('nombretienda')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="calleynum" class="col-md-4 col-form-label text-md-right">{{ __('Calle y Numero') }}</label>

                        <div class="col-md-6">
                            <input id="calleynum" type="text" class="form-control  @error('calleynum') is-invalid @enderror" name="calleynum" autocomplete="off">
                            @error('calleynum')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colonia" class="col-md-4 col-form-label text-md-right">{{ __('Colonia') }}</label>

                        <div class="col-md-6">
                            <input id="colonia" type="text"  class="form-control  @error('colonia') is-invalid @enderror" name="colonia">
                            <div class="justify-content-left" >
                                <div id="resultadobusqueda"></div>
                            </div>
                            @error('colonia')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cpcolonia" class="col-md-4 col-form-label text-md-right">{{ __('Codigo Postal') }}</label>

                        <div class="col-md-6">
                            <input id="cpcolonia" type="text" class="form-control  @error('cpcolonia') is-invalid @enderror" name="cpcolonia">
                            @error('cpcolonia')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="responsable" class="col-md-4 col-form-label text-md-right">{{ __('Responsable de la Tienda') }}</label>

                        <div class="col-md-6">
                            <input id="responsable" type="text" class="form-control  @error('responsable') is-invalid @enderror" name="responsable" autocomplete="off">
                           
                            @error('responsable')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="teltienda" class="col-md-4 col-form-label text-md-right">{{ __('Telefono de la Tienda') }}</label>

                        <div class="col-md-6">
                            <input id="teltienda" type="number" class="form-control" name="teltienda" autocomplete="off">
                        </div>
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
                            <button type="submit" class="btn btn-outline-primary btn-block" id="guardar">
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


<div class="floating">
    <a href="{{ url('/tiendas') }}" class="btn btn-primary btn-fab">
        <i class="fa fa-arrow-left"> Regresar</i>
    </a>
</div>
@endsection

@section('scripts')
<script>
    $(document).on('keyup','#colonia',function(){
        var form = $('#coloniaform')
   		// var url = form.attr('action')
        //    url = url.replace('tiendas','busqueda')
        var url = 'http://localhost/busqueda'
   		var inputbusqueda = $(this).val();
   		var data = form.serialize()
   		url = url+'/'+ inputbusqueda

        $.ajax({
            url: url,        
            type: "POST",             
            data: data,
            dataType: "json", 	
            success: function(data){
                $('#resultadobusqueda').empty();
                $('#resultadobusqueda').addClass("card2");
                //$('#resultadobusqueda').append(data);
        
                for(var i = 0; i< data.length; i++){
                    $('#resultadobusqueda').append(data[i]['botones']);
                }
                if(inputbusqueda == ''){
                    $('#resultadobusqueda').removeClass("card2");
                    $('#resultadobusqueda').empty();
                }
            }
        });
    });

    $(document).on('click','.btn-outline-info',function(){
        $('#resultadobusqueda').removeClass("card2");
        $('#resultadobusqueda').empty();
        var seleccionb = $(this).val();
        var aqui = seleccionb.split("-")
        $('#colonia').val(aqui[0])
        $('#cpcolonia').val(aqui[1])
    });


</script>
@endsection