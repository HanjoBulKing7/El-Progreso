<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 3cm 2cm 2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 30px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 35px;
        }
        h1{
        text-align: center;
        text-transform: uppercase;
        }
        .contenido{
        font-size: 20px;
        }
        #primero{
        background-color: #ccc;
        }
        #segundo{
        color:#44a359;
        }
        #tercero{
        text-decoration:line-through;
        }
        table tr td{
            text-align: center;
           
        }
        table{
            width: 100%;        }
    </style>
    </head>
    <body>
        <header>
            <h1>Galletas - Compra Producto</h1>
        </header>
        @foreach($compra as $datov)
            <h1>Lote: {{ $datov->lote }}</h1>
            <p style="text-align: right">{{ $datov->created_at }}</p>
        
            <div class="contenido">
                <table>
                    <thead>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody>
                        <tr>
                        @foreach($producto as $dato)
                            <tr>
                                <td>{{ $dato->descripcion}}</td>
                                <td>{{ $dato->costo}}</td>
                                <td>{{ $dato->cantidad}}</td>
                                <td>{{ $dato->subtotal}}</td>
                            </tr>
                        @endforeach
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>Total</td>
                            <td>{{ $datov->total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
        <footer>
            <h1>Galletas</h1>
        </footer>
    </body>
</html>