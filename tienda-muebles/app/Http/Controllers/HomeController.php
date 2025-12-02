<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class HomeController extends Controller
{
    public function index()
    {
        $products = Producto::all();
        return view('home', compact('products'));
    }
}
