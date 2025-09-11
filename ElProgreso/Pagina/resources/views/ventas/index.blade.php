@extends('layouts.app')

@section('content')

<section id="team" class="pb-5">
    <div class="floating-arriba">
        <a href="{{ url('historial-venta') }}" class="btn btn-primary btn-fab">
            <i class="fa fa-money"> Historial de Ventas</i>
        </a>
        <a href="{{ url('venta-ruta') }}" class="btn btn-primary btn-fab">
            <i class="fa fa-money"> Ventas por Ruta</i>
        </a>
    </div>
    <div class="container">
        <h5 class="section-title h1">Ventas</h5>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-12 col-lg-4">
                <p>Seleccione Tipo de venta</p>
                <select class="form-control" id="rutavheculoselect" name="rutavheculoselect">
                    @foreach ($rutas as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre_ruta }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-xs-12 col-lg-2">
                <p>Cantidad</p>
                <input id="cantidad" type="number" class="form-control" name="cantidad">
            </div>
            <div class="col-md-2 col-xs-12 col-lg-2">
                <p>Precio</p>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="crMayoreo" name="precio" checked>
                    <label class="custom-control-label" for="crMayoreo">Mayoreo</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="crMenudeo" name="precio">
                    <label class="custom-control-label" for="crMenudeo">Menudeo</label>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 col-lg-4">
                {{ Form::open(['url' => '/busquedaproducto/', 'method' => 'POST','id' => 'buscar_producto']) }}
                <p>Seleccione Producto</p>
                <input id="producto" type="text" class="form-control" name="producto">
                <div class="justify-content-left" >
                    <div id="resultadobusqueda"></div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="margenes p-5">
        <h5>Lista de Productos</h5>
        <table id="listaproducto" class="table table-striped">
            <thead>
                <th>Producto</th>
                <th>Costo Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <th colspan="3" style="text-align: right">Total:</th>
                <th><input type="number" id="total" name="total" class="text-center" disabled></th>
            </tfoot>
        </table>
    </div>
    <div class="text-center">
        @csrf
        <button type="button" name="producto" class="btn btn-info" onclick="finalizarVenta()">Finalizar venta</button>
    </div>

</section>

@endsection

@section('scripts')
    <script>
        var token = document.head.querySelector("meta[name=\"csrf-token\"]").getAttribute('content');
        var listaProductos = [];
        // buscar tiendas con el input
        $(document).on('keyup','#producto',function(){
            var form = $('#buscar_producto')

            var url = 'busquedaproducto'
            var inputbusqueda = $(this).val();
            var data = form.serialize();
            url = url+'/'+ inputbusqueda

            console.log(url);

            $.ajax({
                url: url,
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data){
                    $('#resultadobusqueda').empty();
                    $('#resultadobusqueda').addClass("card2");

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

        var totalfinal = 0
        $(document).on('click','.resultprodu',function(){
            $('#resultadobusqueda').removeClass("card2");
            $('#resultadobusqueda').empty();
            var seleccionb = $(this).val();
            var valor = seleccionb.split("-");
            console.log(valor);
            var cantidad = 0;
            cantidad = $('#cantidad').val();
            var inventario = parseInt(valor[1])



            if( cantidad > inventario ){
                alert('No existe la cantidad necesaria para la venta ')
            }else{
                if($('#crMayoreo').prop('checked')){
                    var precio = valor[4];
                }else if($('#crMenudeo').prop('checked')){
                    var precio = valor[3];
                }
                var total = cantidad * precio;
                var fila = '<tr>'+
                    '<td>'+valor[2]+'</td>' +
                    '<td>'+precio+'</td>' +
                    '<td>'+cantidad+'</td>' +
                    '<td>'+total+'</td>' +
                    '</tr>'

                    totalfinal = total + totalfinal;

                    $('#total').val(totalfinal);

                $('#listaproducto tbody').append(fila)
                var producto = {
                    id_producto: valor[0],
                    costo_unitario: precio,
                    cantidad: cantidad,
                    subtotal: total
                };
                listaProductos.push(producto);
            }
        });

        function finalizarVenta() {
            var data = {
                _token: token,
                id_ruta: $('#rutavheculoselect').val(),
                totalfin: $('#total').val(),
                lista_productos: listaProductos
            };
            var url = 'registrar-venta';
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                dataType: "json",
                success: function(res){
                    alert(res.message);
                    if (res.ok) {
                        limpiar();
                    }
                },
                error: function() {
                    alert('Ocurrió un error con la aplicación\nContacte al administrador del sistema');
                }
            });
        }

        function limpiar() {
            $('#listaproducto tbody').empty();
            totalfinal = 0;
            $('#total').val(totalfinal);
            listaProductos = [];
        }
    </script>
@endsection
