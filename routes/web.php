<?php

use App\Models\Inventario;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Crud_Almacen;
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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/panel_de_control/Logistica', function () {
    return view('Logistica');
})->middleware('auth');

Route::get('Movimientos/Entrada_Inventario',function(){
    return view('Entrada_Inventario');
})->Middleware('auth');

Route::get('/prueba', [Crud_Movimientos::class, 'Movimientos'])->middleware('auth');

Route::get('movimientos', [Crud_nventario::class, 'index'])->name('movimientos.index');
Route::post('materiales', [Crud_Materiales::class, 'PostMaterial'])->name('materiales.create');
Route::get('inventario', [Crud_nventario::class, 'PostInventario'])->name('inventario.index');

Route::post( 'almacenes', [Crud_Almacen::class, 'PostAlmacen'] )->name('Almacen.create');

Route::post('proveedores',[Crud_Proveedor::class,'PostProveedor'])->name('provedores.create');

Route::post('movimientos', [Crud_Movimientos::class, 'PostMovimientoIngreso'])->name('movimientos.ingreso');

Route::get('Perfil',[AuthController::class, 'InformacionUser'])->name('datos.usuario');

Route::get('/panel_de_control',[DashboardController::class, 'index'])->middleware('auth');


Route::get('/Movimientos/tabla',[Crud_Movimientos::class,'vistaAlmacen'])->name('movimiento.salida.ver');
Route::post('/Movimientos/tabla/salida',[Crud_Movimientos::class,'MovimientoSalida'])->name('movimiento.salida');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');