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

    Route::get('/configuracion',[Crud_Configuracion::class, 'index']);

    Route::get('/Proveedores',[Crud_Proveedor::class,'VistaProveedores']);

    Route::get('/Proveedores/delete',[Crud_Proveedor::class,'Delete']); 

    
});



Route::get('/dashboard', function () {return view('dashboard'); })->middleware('auth');


//inventario !!!!cambiar nombre!!!!
Route::get('/panel_de_control/Logistica',[Crud_nventario::class,'VistaInventario'])->middleware('auth');
//******************************************************************************************************** */



Route::get('Movimientos/Entrada_Inventario',function(){return view('Entrada_Inventario');})->Middleware('auth');

Route::get('movimientos', [Crud_nventario::class, 'index'])->name('movimientos.index');
Route::post('materiales', [Crud_Materiales::class, 'PostMaterial'])->name('materiales.create');
Route::get('inventario', [Crud_nventario::class, 'PostInventario'])->name('inventario.index');
Route::delete('inventario',[Crud_nventario::class,'destroy'])->name('inventarios.destroy');

Route::post( 'almacenes', [Crud_Almacen::class, 'PostAlmacen'] )->name('Almacen.create');

Route::post('proveedores',[Crud_Proveedor::class,'PostProveedor'])->name('provedores.create');

Route::post('/movimientos/tabla/Ingreso', [Crud_Movimientos::class, 'PostMovimientoIngreso'])->name('movimientos.ingreso');
// Ruta para actualizar (Método PUT)
Route::put('/movimientos/{movimiento}', [Crud_Movimientos::class, 'update'])->name('movimientos.update');
// Ruta para eliminar (Soft Delete, Método DELETE)
Route::delete('/movimientos/{movimiento}', [Crud_Movimientos::class, 'destroy'])->name('movimientos.destroy');


Route::get('Perfil',[AuthController::class, 'InformacionUser'])->name('datos.usuario');

Route::get('/panel_de_control',[DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/movimientos-periodo', [DashboardController::class, 'getMovimientosPorPeriodo'])->middleware('auth');


Route::get('/Movimientos/tabla',[Crud_Movimientos::class,'Movimientos'])->middleware('auth');
Route::post('/Movimientos/tabla/salida',[Crud_Movimientos::class,'MovimientoSalida'])->name('movimientos.salida');
Route::post('/Movimientos/tabla/salida2',[Crud_Movimientos::class,'MovimientoSalida2'])->name('movimientos.salida2');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');