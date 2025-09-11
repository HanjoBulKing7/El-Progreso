@extends('layouts.app')

@section('title', __('Admins'))

@section('header-button')
    <create-admins></create-admins>
@endsection



@section('content')
    <head>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <section>
        <div class="row" id="app">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Instrucciónes</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <p class="card-text">
                                En esta sección puedes agregar nuevas metas asignadas para cada ruta, asi como modificarlas, observarlas o borrarlas
                            </p>
                            <div class="table-responsive">
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <nominas-tabla></nominas-tabla>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
