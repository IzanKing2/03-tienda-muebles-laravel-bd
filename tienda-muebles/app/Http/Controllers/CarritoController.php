<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        return view('carrito.index');
    }

    public function GuardarCookiePreferencia(Request $request)
    {
        $paginacion = $request->input('paginacion');
        $tema = $request->input('tema');
        $moneda = $request->input('moneda');


    }
}
