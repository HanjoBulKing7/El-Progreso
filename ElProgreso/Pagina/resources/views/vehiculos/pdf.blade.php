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
            <h1>Galletas</h1>
        </header>
        <h1>Vehiculo 4</h1>
        <hr>
        
        
        <div class="contenido">
            <table>
                <thead>
                    <th>Aspecto</th>
                    <th>Estado</th>
                    <th>Observación</th>
                </thead>
                <tbody>
                    <tr>
                    @foreach($data as $dato)
                        <tr>
                            <td>{{ $dato->aspecto}}</td>
                            <td>{{ $dato->estado}}</td>
                            <td>{{ $dato->observaciones}}</td>
                        </tr>
                    @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        <footer>
            <h1>Galletas</h1>
        </footer>
    </body>
</html>