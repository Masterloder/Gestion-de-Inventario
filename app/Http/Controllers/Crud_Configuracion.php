<?php

namespace App\Http\Controllers;

use App\Models\Materiales;
use Illuminate\Http\Request;

class Crud_Configuracion extends Controller
{
    public function index()
    {

        $materiales = Materiales::all();
        

        return view('Configuracion.index', compact('materiales'));
    }
}
