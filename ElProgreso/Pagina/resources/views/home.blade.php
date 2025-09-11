@extends('layouts.app')

@section('content')
<!-- Team -->
<section id="team" class="pb-5">
    <div class="container">
        <h5 class="section-title h1">Menú</h5>
        <div class="row">
            <!-- Usuarios -->
            @if(Auth::user()->fktiporol == 1)
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('img/user.png') }}" alt="card image"></p>
                                    <h4 class="card-title">Usuarios</h4>
                                    <p class="card-text">Esta seccion es para las acciones de los usuarios del sistema.</p>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">Usuarios</h4>
                                    <p class="card-text">En Este apartado se puede encontrar información de los Usuarios. Se pueden Crear modificar o eliminar a los usuarios del sistema.</p>
                                    <a href="{{ url('usuarios') }}"><button class="btn btn-outline-primary btn-block">Ingresar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- ./usuarios -->
            <!-- Proveedores -->
            @if(Auth::user()->fktiporol == 1)
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('img/users.png') }}" alt="card image"></p>
                                    <h4 class="card-title">Proveedores</h4>
                                    <p class="card-text">Esta seccion es para las acciones de los proveedores del sistema..</p>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">Proveedores</h4>
                                    <p class="card-text">En Este apartado se puede encontrar información de los proveedores. Se pueden Crear modificar o eliminar a los proveedores del sistema.</p>
                                    <a href="{{ url('proveedores') }}"><button class="btn btn-outline-primary btn-block">Ingresar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- ./proveedores -->
            <!-- Vehiculos -->
            @if(Auth::user()->fktiporol == 1)
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('img/pickup.png') }}" alt="card image"></p>
                                    <h4 class="card-title">Vehiculo</h4>
                                    <p class="card-text">Esta sección es para los vehiculos de la empresa.</p>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">Vehiculo</h4>
                                    <p class="card-text">
                                        Se pueden realizar los siguientes movimientos
                                        <ul>
                                            <li>Alta de vehiculo</li>
                                            <li>Baja de vehiculo</li>
                                            <li>Actualizacion de vehiculo</li>
                                        </ul>

                                    </p>
                                    <a href="{{ url('vehiculos') }}"><button class="btn btn-outline-primary btn-block">Ingresar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- ./Vehiculos -->
            <!-- Productos -->
            @if(Auth::user()->fktiporol == 1)
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('img/producto.png') }}" alt="card image"></p>
                                    <h4 class="card-title">Productos</h4>
                                    <p class="card-text">Esta sección es para los productos de la empresa.</p>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">Producto</h4>
                                    <p class="card-text">
                                        Se pueden realizar los siguientes movimientos
                                        <ul>
                                            <li>Alta de producto</li>
                                            <li>Baja de producto</li>
                                            <li>Actualizacion de producto</li>
                                        </ul>
                                    </p>
                                    <a href="{{ url('productos') }}"><button class="btn btn-outline-primary btn-block">Ingresar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- ./Productos -->
            <!-- Tienda -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('img/tienda.png') }}" alt="card image"></p>
                                    <h4 class="card-title">Tienda</h4>
                                    <p class="card-text">Esta sección se administraran las tiendas de las rutas.</p>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">Tiendas</h4>
                                    <p class="card-text">
                                        Se pueden realizar los siguientes movimientos
                                        <ul>
                                            <li>Alta de la Tienda</li>
                                            <li>Baja de la Tienda</li>
                                            <li>Actualizacion de la Tienda</li>
                                        </ul>
                                    </p>
                                    <a href="{{ url('tiendas') }}"><button class="btn btn-outline-primary btn-block">Ingresar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Tienda -->
            <!-- Rutas -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('img/ruta.png') }}" alt="card image"></p>
                                    <h4 class="card-title">Rutas</h4>
                                    <p class="card-text">Esta sección se administraran las rutas programadas.</p>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">Rutas</h4>
                                    <p class="card-text">Se pueden realizar los siguientes movimientos
                                        <ul>
                                            <li>Alta de Ruta</li>
                                            <li>Baja de Ruta</li>
                                            <li>Actualizacion de Ruta</li>
                                        </ul>
                                    </p>
                                    <a href="{{ url('rutas') }}"><button class="btn btn-outline-primary btn-block">Ingresar</button></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Rutas -->
            <!-- Gastos -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('img/gastos.png') }}" alt="card image"></p>
                                    <h4 class="card-title">Gastos</h4>
                                    <p class="card-text">Esta sección se administraran los gastos.</p>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">Gastos</h4>
                                    <p class="card-text">Se pueden realizar los siguientes movimientos
                                        <ul>
                                            <li>Administración de Gastos</li>
                                        </ul>
                                    </p>
                                    <a href="{{ url('gastos') }}"><button class="btn btn-outline-primary btn-block">Ingresar</button></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./gastos -->
            <!-- Ventas -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('img/ventas.png') }}" alt="card image"></p>
                                    <h4 class="card-title">Ventas</h4>
                                    <p class="card-text">Sección de Ventas.</p>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">Ventas</h4>
                                    <p class="card-text">Se pueden realizar los siguientes movimientos
                                        <ul>
                                            <li>Cualquier tipo de Venta</li>
                                        </ul>
                                    </p>
                                    <a href="{{ url('ventas') }}"><button class="btn btn-outline-primary btn-block">Ingresar</button></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./ventas -->

            <!-- App -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('img/applogo.png') }}" alt="card image"></p>
                                    <h4 class="card-title">App</h4>
                                    <p class="card-text">Sección de App.</p>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">App</h4>
                                    <p class="card-text">Se pueden realizar los siguientes movimientos
                                    <ul>
                                        <li>Vista de datos capturados por la app</li>
                                    </ul>
                                    </p>
                                    <a href="{{ url('apprutavista') }}">
                                        <button class="btn btn-outline-primary btn-block">Ingresar</button>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./app -->

        </div>
    </div>
</section>
<!-- Team -->
@endsection
