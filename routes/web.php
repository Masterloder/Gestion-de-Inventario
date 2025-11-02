<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Crud_nventario;
use App\Models\Post;
use App\Models\PostMovimientos;
use App\Models\Provedores;

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

Route::get('/prueba', function(){
    /*
    $Post = new Provedores() ;
    $Post->codigo = Faker\Factory::create()->unique()->numberBetween(1000, 9999);
    $Post->nombre = Faker\Factory::create()->name();
    $Post->contacto = Faker\Factory::create()->unique()->safeEmail();
    $Post->direccion = Faker\Factory::create()->address();
    $Post->save();
    return $Post;

    $POST = Post::orderBy('id', 'DESC')
    ->select('codigo', 'nombre', 'contacto', 'direccion')
    ->get();
    $POST = Post::find(1 );
    $POST->delete();
    return "Eliminado correctamente";
    */

});

Route::get('movimientos', [Crud_nventario::class, 'index'])->name('movimientos.index');
Route::get('provedores', [Crud_nventario::class, 'PostProvedores'])->name('provedores.create');
Route::get('inventario', [Crud_nventario::class, 'PostInventario'])->name('inventario.index');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');