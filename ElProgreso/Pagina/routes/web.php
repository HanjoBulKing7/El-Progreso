<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// use Symfony\Component\Routing\Route;
use App\Http\Controllers\appRutaVistaController;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\VentasController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
// Rutas para pagina de usuarios
Route::resource('/usuarios', UsuarioController::class)->middleware('auth','tiporol');
Route::get('/usuarios-data', [UsuarioController::class, 'usuarioData'])->name('usuario.data')->middleware('auth','tiporol');

// vistas para pagina de porveedores
Route::resource('/proveedores', \App\Http\Controllers\ProveedorController::class)->middleware('auth','tiporol');
Route::get('/proveedores-data', [\App\Http\Controllers\ProveedorController::class, 'proveedorData'])->name('proveedor.data')->middleware('auth','tiporol');

// vistas para pagina de producto
Route::resource('/productos', ProductoController::class)->middleware('auth','tiporol');
Route::get('/productos-data', [ProductoController::class, 'productoData'])->name('producto.data')->middleware('auth','tiporol');
Route::get('/ingresar', [ProductoController::class, 'Ingresar'])->middleware('auth','tiporol');
Route::post('/bproductoIngreso/{buscar?}', [ProductoController::class, 'busquedaProductoIngreso'])->name('busqueda.ingreso')->middleware('auth','tiporol');
Route::post('/registrar-compra', [ProductoController::class, 'registrarCompra'])->name('registrar-compra')->middleware('auth', 'tiporol');
Route::get('/historial-compra', [ProductoController::class, 'historialCompra'])->name('historial-compra')->middleware('auth', 'tiporol');
Route::get('/compra-data', [ProductoController::class, 'compraData'])->name('compra.data')->middleware('auth','tiporol');
Route::get('/pdfticketcompra/{id}', [ProductoController::class, 'ticket'])->middleware('auth','tiporol');


// vistas para pagina de Vehiculo
Route::resource('/vehiculos', VehiculoController::class)->middleware('auth','tiporol');
Route::get('/vehiculo-data', [VehiculoController::class, 'vehiculoData'])->name('vehiculo.data')->middleware('auth','tiporol');
Route::get('/buscarvehiculo/{id}', [VehiculoController::class, 'buscarkmVehiculo'])->middleware('auth','tiporol');
Route::post('/registrokm', [VehiculoController::class, 'guardarkmVehiculo'])->middleware('auth','tiporol');
Route::get('/obtenervehi', [VehiculoController::class, 'obtenerVehiculo'])->middleware('auth','tiporol');
Route::post('/checklist', [VehiculoController::class, 'crearCheckList'])->middleware('auth','tiporol');
Route::get('/pdfchecklist', [VehiculoController::class, 'reporteCheckList'])->middleware('auth','tiporol');
// resource para tipo de productos.
Route::resource('/t_productos', '\App\Http\Controllers\TipoProdController')->middleware('auth','tiporol');

// resource para licencia
Route::resource('/licencias', 'LicenciaController')->only([
    'store'
]);

// vistas para pagina de tienda
Route::resource('/tiendas', TiendaController::class)->middleware('auth','tiporol');
Route::get('/tienda-data', [TiendaController::class, 'tiendaData'])->name('tienda.data')->middleware('auth','tiporol');
Route::post('/busqueda/{buscar?}', [TiendaController::class, 'busquedaData'])->name('busqueda.data')->middleware('auth','tiporol');
Route::get('/qr/generar/{id}', [TiendaController::class, 'generateQR']);
Route::get('/generate-pdf/{id?}', [TiendaController::class, 'generateAllQR']);

//resource para rutas
Route::resource('/rutas', RutaController::class)->middleware('auth','tiporol');
Route::get('/ruta-data', [RutaController::class, 'rutaData'])->name('ruta.data')->middleware('auth','tiporol');
Route::post('/busquedatienda/{buscar?}', [RutaController::class, 'busquedaTienda'])->name('busqueda.data')->middleware('auth','tiporol');
Route::post('/gtiendaruta', [RutaController::class, 'guardartiendaruta'])->middleware('auth','tiporol');
Route::get('/ruta-tienda-data', [RutaController::class, 'rutaTiendaData'])->name('ruta.tienda.data')->middleware('auth','tiporol');
Route::post('/rutavehiculo', [RutaController::class, 'rutaVehiculo'])->middleware('auth','tiporol');
Route::get('/ruta-vehiculo-data', [RutaController::class, 'rutaVehiculoData'])->name('ruta.vehiculo.data')->middleware('auth','tiporol');
Route::get('/rv_baja/{buscar}', [RutaController::class, 'rutaVehiculoBaja'])->middleware('auth','tiporol');
Route::get('/rt_baja/{buscar}', [RutaController::class, 'rutaTiendaBaja'])->middleware('auth','tiporol');
Route::get('/rutas/{id}/usuario', [RutaController::class, 'obtenerUsuarioAsociado'])->middleware('auth','tiporol')->name('rutas.usuario');

//resources para gastos
Route::resource('/gastos', GastosController::class)->middleware('auth','tiporol');
Route::get('/gastosmes-data', [GastosController::class, 'gastosmesData'])->name('gastos.mes.data')->middleware('auth','tiporol');
Route::get('/gastos-data', [GastosController::class, 'gastosData'])->name('gastos.data')->middleware('auth','tiporol');
Route::get('/gasto_baja/{buscar}', [GastosController::class, 'gastoBaja'])->middleware('auth','tiporol');
Route::get('/gasto_activo/{buscar}', [GastosController::class, 'gastoActivo'])->middleware('auth','tiporol');
Route::post('/tipogastos', [GastosController::class, 'tipoGastos'])->middleware('auth','tiporol');

// ventas
Route::resource('/ventas', VentasController::class,[
    'only' => ['index']
]);
Route::post('/busquedaproducto/{buscar?}', [VentasController::class, 'busquedaProducto'])->name('busqueda.data')->middleware('auth','tiporol');
Route::post('/registrar-venta', [VentasController::class, 'registrarVenta'])->name('registrar-venta')->middleware('auth', 'tiporol');
Route::get('/historial-venta', [VentasController::class, 'historialVenta'])->name('historial-venta')->middleware('auth', 'tiporol');
Route::get('/historial-data', [VentasController::class, 'ventasData'])->name('historial.data')->middleware('auth','tiporol');
Route::get('/pdfticket/{id}', [VentasController::class, 'ticket'])->middleware('auth','tiporol');
Route::get('/venta-ruta', [VentasController::class, 'VentaxRuta'])->name('venta-ruta')->middleware('auth', 'tiporol');
Route::post('/busquedaproductoRuta/{ruta?}/{buscar?}', [VentasController::class, 'busquedaproductoRuta'])->name('busquedaruta.data')->middleware('auth','tiporol');
Route::post('/registrar-venta-ruta', [VentasController::class, 'registrarVentaRuta'])->name('registrar-venta-ruta')->middleware('auth', 'tiporol');
Route::get('/pdfruta', [VentasController::class, 'reporteRuta'])->middleware('auth','tiporol');

Route::get('/users-auth', [UsuarioController::class, 'obtenerUsuarioAutenticado'])->name('users.auth');
Route::get('/users/{id}', [UsuarioController::class, 'show'])->name('users.show');
Route::get('/rutas/{ruta_id}/venta-devoluciones-mensual/{rango_fechas}', [UsuarioController::class, 'obtenerVentaYDevolucionesMensuales'])->name('users.venta-devoluciones-mensual');


// Ruta para la vista de la app
Route::resource('/apprutavista', appRutaVistaController::class)->middleware('auth','tiporol');
Route::get('/appvista-data', [appRutaVistaController::class, 'AppRutaVistaData'])->name('appvista.data')->middleware('auth','tiporol');
Route::get('/apppedidos-data', [appRutaVistaController::class, 'AppPedidos'])->name('apppedidos.data')->middleware('auth','tiporol');


// route para imagenes
Route::get('/img/{filename}', function ($filename) {
    $path = 'images/'.$filename; // Asume que estás usando el disco 'local'

    if (!Storage::exists($path)) {
        abort(404);
    }

    $file = Storage::get($path);
    $type = Storage::mimeType($path);

    return response()->make($file, 200)->header("Content-Type", $type);
});;

Route::middleware(['auth', 'tiporol'])->group(function () {
    require __DIR__ . '/Rutas/ruta.php';
    require __DIR__ . '/Finanzas/Nomina/nomina.php';
    require __DIR__ . '/Finanzas/Nomina/bono_anuales.php';
});

