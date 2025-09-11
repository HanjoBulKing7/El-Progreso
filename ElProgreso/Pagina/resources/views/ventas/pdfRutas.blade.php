@php
  $tvendido =0;
  $tvuelta =0;  
  $totalfinal = 0;
@endphp
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

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border-collapse: collapse;
            border: 1px solid black; /* Set the border for table cells */
            padding: 8px;
        }
        
    </style>
    </head>
    <body>
        <header>
            <h1>Galletas - Ticket de Venta</h1>
        </header>
        
            <h1>Reporte ruta: {{ $ruta }}</h1>
            <p style="text-align: right">{{ $fecha }}</p>
            <div class="contenido">
                <table>
                    <thead>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Abordo</th>
                        <th>Tipo</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody>
                        <tr>
                        @foreach($data as $dato)
                            <tr>
                                <td>{{ $dato->descripcion }}</td>
                                <td>{{ $dato->costo}}</td>
                                <td>{{ $dato->cantidad}}</td>
                                <td>{{ $dato->abordo}}</td>
                                <td>{{ $dato->tipo_movi}}</td>
                                <td>{{ $dato->subtotal}}</td>
                            </tr>
                            @if( $dato->tipo_movi == 'Venta' )
                                @php 
                                $tvendido = $dato->subtotal + $tvendido;  
                                @endphp
                            @else
                                @php 
                                $tvuelta = $dato->subtotal + $tvuelta ; 
                                @endphp
                            @endif

                        @endforeach
                        @php
                            $totalfinal = $tvendido - $tvuelta;
                        @endphp
                        </tr>
                        
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td style="background-color: darkgray">Total Vendido</td>
                            <td style="background-color: rgb(104, 187, 145)">{{ $tvendido }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td style="background-color: darkgray">Total Devuelto</td>
                            <td style="background-color: rgb(182, 68, 68)">{{ $tvuelta }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td style="background-color: darkgray">Total Final</td>
                            <td style="background-color: rgb(91, 182, 68)">{{ $totalfinal }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <footer>
            <h1>Galletas</h1>
        </footer>
    </body>
</html>