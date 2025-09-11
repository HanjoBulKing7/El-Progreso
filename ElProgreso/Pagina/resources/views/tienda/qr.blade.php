@extends('layouts.app')

@section('content')

<section class="pb-5">
    <div class="container">
        <div class="floating-arriba">
            <a href="{{ url('/tiendas') }}" class="btn btn-primary btn-fab">
                Regresar
            </a>
        </div>
        <h5 class="section-title h1">Nombre de la tienda: {{ $data->nombre_tienda }}</h5>
    </div>
    <div class="container-mod">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 centered">
                {{$qrCode}}
            </div>
        </div>
    </div>
</section>

@endsection