<?php

use App\Models\Inventario;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Crud_Almacen;
use App\Http\Controllers\Crud_Configuracion;
use App\Http\Controllers\Crud_Materiales;
use App\Http\Controllers\Crud_Movimientos;
use App\Http\Controllers\Crud_nventario;
use App\Http\Controllers\Crud_Proveedor;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformesController;
use App\View\Components\InformeController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/Inicio_de_sesion', function () {
    return view('Inicion_de_sesion');
});
Route::get('/registro', function () {
    return view('registro');
});


Route::middleware('auth')->group(function () {

    Route::prefix('Informes')->group(function () {

     Route::get('/', [InformesController::class, 'index'])->name('Informes.index');

        // Rutas para las vistas de informes específicos (HTML/PDF)
        Route::get('/diario', [InformesController::class, 'InformeDiario'])->name('Informes.Informes');
        Route::get('/semanal', [InformesController::class, 'InformeSemanal'])->name('informes.semanal');
        Route::get('/mensual', [InformesController::class, 'InformeMensual'])->name('informes.mensual');
        Route::get('/trimestral', [InformesController::class, 'InformeTrimestral'])->name('informes.trimestral');
        Route::get('/anual', [InformesController::class, 'InformeAnual'])->name('informes.anual');
        // Rutas para obtener datos JSON (si usas gráficas con Chart.js o AJAX)
        Route::get('/datos-periodo', [InformesController::class, 'getMovimientosPorPeriodo'])->name('informes.datos.periodo');
    });

    Route::get('/configuracion', [Crud_Configuracion::class, 'index']);
    Route::get('/configuracion/tabla-materiales', [Crud_Configuracion::class, 'tablaMateriales']);

    Route::post('/configuracion/tabla-materiales/{id}', [Crud_Configuracion::class, 'materialesupdate'])->name('materiales.postupdate');
    Route::delete('/configuracion/tabla-materiales/delete/{id}', [Crud_Configuracion::class, 'materialesDelete'])->name('materiales.delete');
    Route::get('/configuracion/tabla-unidades-medicion', [Crud_Configuracion::class, 'tablaUnidadesMedicion']);
    Route::post('/configuracion/tabla-unidades-medicion', [Crud_Configuracion::class, 'UnidadMedicionCrear'])->name('unidad-medicion.create');
    Route::put('/configuracion/tabla-unidades-medicion/{id}', [Crud_Configuracion::class, 'UnidadMedicionUpdate'])->name('unidad-medicion.update');
    Route::delete('/configuracion/tabla-unidades-medicion/delete/{id}', [Crud_Configuracion::class, 'UnidadMedicionDelete'])->name('unidad-medicion.delete');

    Route::get('/configuracion/tabla-categorias', [Crud_Configuracion::class, 'tablaCategorias'])->name('Configuracion.TablaCategorias');

    Route::post('/configuracion/tabla-categorias/create', [Crud_Configuracion::class, 'store'])->name('categorias_especificas.create');
    Route::put('/configuracion/tabla-categorias/update/{id}', [Crud_Configuracion::class, 'PostCategoria'])->name('categorias.update');
    Route::post('/configuracion/tabla-categorias/categorias', [Crud_Configuracion::class, 'CategoriaCrear'])->name('categorias.create');
    Route::post('/configuracion/tabla-categorias/categorias-especificas', [Crud_Configuracion::class, 'CategoriaEspecificaCrear'])->name('categorias-especificas.create');
    Route::delete('/configuracion/categorias-especificas/delete/{id}', [Crud_Configuracion::class, 'DeleteCategoriat'])->name('categorias_especificas.delete');
    Route::delete('/configuracion/categorias/delete/{id}', [Crud_Configuracion::class, 'DeleteCategoria'])->name('categorias.delete');


    Route::get('/Proveedores', [Crud_Proveedor::class, 'VistaProveedores']);
    Route::post('proveedores', [Crud_Proveedor::class, 'PostProveedor'])->name('provedores.create');
    Route::put('proveedores/{id}', [Crud_Proveedor::class, 'update'])->name('proveedores.update');
    Route::delete('/proveedores/delete/{id}', [Crud_Proveedor::class, 'Delete'])->name('proveedores.delete');

    Route::get('/Usuarios', [Crud_Configuracion::class, 'VistaUsuarios']);
    Route::post('usuarios', [Crud_Configuracion::class, 'PostUsuario'])->name('usuarios.create');
    Route::put('usuarios/{id}', [Crud_Configuracion::class, 'updateUsuario'])->name('usuarios.update');
    Route::post('usuarios/cambiar-password/{id}', [Crud_Configuracion::class, 'cambiarPassword'])->name('usuarios.cambiarPassword');

    Route::post('/usuarios/autorizacion/{id}', [Crud_Configuracion::class, 'cambiarAutorizacion'])->name('usuarios.autorizacion');

    Route::delete('/usuarios/delete/{id}', [Crud_Configuracion::class, 'DeleteUsuario'])->name('usuarios.delete');

    //leer notificaciones 
    Route::get('/notificaciones/leer/{id}', function ($id) {
        // Usamos findOrFail para asegurar que solo buscamos esa notificación específica del usuario
        $notification = auth()->user()->notifications()->findOrFail($id);

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return response()->json(['status' => 'ok']);
    });


    //notificaciones
    Route::get('/notificaciones/leidas', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notificaciones.marcarLeidas');

    Route::get('/notificaciones/Materiales', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notificaciones.eliminarTodas');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');


//inventario !!!!cambiar nombre!!!!
Route::get('/panel_de_control/Logistica', [Crud_nventario::class, 'VistaInventario'])->middleware('auth');
Route::put('/panel_de_control/Logistica/salidas/{id}', [Crud_nventario::class, 'update'])->name('salidas.update');
//******************************************************************************************************** */



Route::get('Movimientos/Entrada_Inventario', function () {
    return view('Entrada_Inventario');
})->Middleware('auth');

Route::get('movimientos', [Crud_nventario::class, 'index'])->name('movimientos.index');
Route::post('materiales', [Crud_Materiales::class, 'PostMaterial'])->name('materiales.create');
Route::get('inventario', [Crud_nventario::class, 'PostInventario'])->name('inventario.index');
Route::delete('inventario/{id}', [Crud_nventario::class, 'destroy'])->name('inventarios.destroy');

Route::post('almacenes', [Crud_Almacen::class, 'PostAlmacen'])->name('Almacen.create');


Route::post('/movimientos/tabla/Ingreso', [Crud_Movimientos::class, 'PostMovimientoIngreso'])->name('movimientos.ingreso');
// Ruta para actualizar (Método PUT)
Route::put('/movimientos/{movimiento}', [Crud_Movimientos::class, 'update'])->name('movimientos.update');
// Ruta para eliminar (Soft Delete, Método DELETE)
Route::delete('/movimientos/{movimiento}', [Crud_Movimientos::class, 'destroy'])->name('movimientos.destroy');


Route::get('Perfil', [AuthController::class, 'InformacionUser'])->name('datos.usuario');

Route::get('/panel_de_control', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/movimientos-periodo', [DashboardController::class, 'getMovimientosPorPeriodo'])->middleware('auth');


Route::get('/Movimientos/tabla', [Crud_Movimientos::class, 'Movimientos'])->middleware('auth');
Route::post('/Movimientos/tabla/salida', [Crud_Movimientos::class, 'MovimientoSalida'])->name('movimientos.salida');
Route::post('/Movimientos/tabla/salida2', [Crud_Movimientos::class, 'MovimientoSalida2'])->name('movimientos.salida2');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
