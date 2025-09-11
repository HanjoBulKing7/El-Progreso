@extends('layouts.app')

@section('content')

<section id="team" class="pb-5">
    <div class="floating-arriba">
        <a href="{{ url('historial-compra') }}" class="btn btn-primary btn-fab">
            <i class="fa fa-shopping-cart">Historial de Compras</i>
        </a>
    </div>
    <div class="container">
        <h5 class="section-title h1">Ingreso de Producto</h5>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-2 col-xs-12 col-lg-2">
                <p>Lote</p>
                <input id="lote" type="number" class="form-control" name="lote">
            </div>
            <div class="col-md-2 col-xs-12 col-lg-2">
                <p>Cantidad</p>
                <input id="cantidad" type="number" class="form-control" name="cantidad">
            </div>
            <div class="col-md-4 col-xs-12 col-lg-4">
                <form action="{{ url('/bproductoIngreso/') }}" method="POST" id="buscar_producto">
                    @csrf
                <p>Seleccione Producto</p>
                <input id="producto" type="text" class="form-control" name="producto">
                <div class="justify-content-left" >
                    <div id="resultadobusqueda"></div>
                </div>
                </form>
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
        <button type="button" name="comprar" class="btn btn-info" onclick="finalizarCompra()">Ingresar Producto</button>
        <button type="button" name="limpiar" class="btn btn-info" onclick="limpiar()">Borrar Lista</button>
    </div>

</section>

@endsection

@section('scripts')
    <script>
        var listaProductos = [];
        // buscar tiendas con el input
        $(document).on('keyup','#producto',function(){
            var form = $('#buscar_producto')

            var url = 'bproductoIngreso'
            var inputbusqueda = $(this).val();
            var data = form.serialize();
            url = url+'/'+ inputbusqueda

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
            $('#producto').val('');
            var seleccionb = $(this).val();
            var valor = seleccionb.split("-");
            var cantidad = 0;
            cantidad = $('#cantidad').val();

            var precio = valor[2];
            var total = cantidad * precio;
            var fila = '<tr>'+
                '<td>'+valor[1]+'</td>' +
                '<td>'+precio+'</td>' +
                '<td>'+cantidad+'</td>' +
                '<td>'+total+'</td>' +
                '</tr>'

                totalfinal = total + totalfinal;

                $('#total').val(totalfinal);

            $('#listaproducto tbody').append(fila)
            var producto = {
                id_producto: valor[0],
                cantidad: cantidad,
                costo_unitario: precio,
                subtotal: total
            };
            listaProductos.push(producto);

        });

        function finalizarCompra() {
            var data = {
                _token: $('input[name="_token"]').val(), // Obtener el token CSRF por nombre
                lote: $('#lote').val(),
                total: $('#total').val(),
                lista_productos: listaProductos
            };
            console.log(data);
            var url = 'registrar-compra';
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                dataType: "json",
                success: function(res){
                    console.log(res);
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
            $('#lote').val(totalfinal);
            $('#cantidad').val(totalfinal);
            listaProductos = [];
        }
    </script>
@endsection

