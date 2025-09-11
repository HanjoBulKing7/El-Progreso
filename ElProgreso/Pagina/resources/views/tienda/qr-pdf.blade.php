
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Qr</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
<section class="pt-5">
<div class="container">
    <div class="row">
    @if($tiendas->isEmpty())
        <p>No se encontraron tiendas.</p>
    @else
        @foreach($tiendas as $index => $qrcode)
            @if($index % 3 == 0 && $index != 0)
                </div><div class="row">
            @endif

            <div class="col-md-4 col-lg-4 col-sm-4 centered">
                {!! QrCode::size(200)->generate('Id:'.$qrcode->id.',lat:21.885256,lng:-102.291568') !!}
                <p>Tienda <strong>{{ $qrcode->nombre_tienda }}</strong></p>
            </div>
        @endforeach
    @endif
    </div>
</div>
   
</section>    
</body>
</html>

