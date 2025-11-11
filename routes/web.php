<?php

use App\Models\Inventario;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Crud_Almacen;
use App\Http\Controllers\Crud_Materiales;
use App\Http\Controllers\Crud_nventario;
use App\Http\Controllers\Crud_Proveedor;
use App\Models\Post;
use App\Models\PostMovimientos;
use App\Models\Provedores;
use App\Models\Materiales;
use Faker\Factory;

use function Laravel\Prompts\select;

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

Route::get('/panel_de_control', function () {
    return view('panel_de_control');
})->middleware('auth');

Route::get('/panel_de_control/Logistica', function () {
    return view('Logistica');
})->middleware('auth');

Route::get('/Movimientos', function(){
    return view('Movimientos');
})->middleware('auth');

Route::get('/prueba', function(){
         $Post = new Inventario();
         $Post = Inventario::find('1');
         return $Post['id_material'];

});

Route::get('movimientos', [Crud_nventario::class, 'index'])->name('movimientos.index');
Route::post('materiales', [Crud_Materiales::class, 'PostMaterial'])->name('materiales.create');
Route::get('inventario', [Crud_nventario::class, 'PostInventario'])->name('inventario.index');

Route::post( 'almacenes', [Crud_Almacen::class, 'PostAlmacen'] )->name('Almacen.create');

Route::post('proveedores',[Crud_Proveedor::class,'PostProveedor'])->name('provedores.create');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');