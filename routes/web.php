<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('Inicion_de_sesion');
});
Route::get('/registro', function () {
    return view('registro');
});