<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImagenProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $imagenes = \App\Models\Imagen::all();
        return view('imagen_productos.index', compact('imagenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $productos = \App\Models\Producto::all();
        return view('imagen_productos.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'url_imagen' => 'required|url',
        ]);
        $imagen = new \App\Models\Imagen();
        $imagen->producto_id = $request->producto_id;
        $imagen->url_imagen = $request->url_imagen;
        $imagen->save();
        return redirect()->route('imagen_productos.index')->with('success', 'Imagen de producto creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $imagen = \App\Models\Imagen::findOrFail($id);
        return view('imagen_productos.show', compact('imagen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $imagen = \App\Models\Imagen::findOrFail($id);
        $productos = \App\Models\Producto::all();
        return view('imagen_productos.edit', compact('imagen', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'url_imagen' => 'required|url',
        ]);
        $imagen = \App\Models\Imagen::findOrFail($id);
        $imagen->producto_id = $request->producto_id;
        $imagen->url_imagen = $request->url_imagen;
        $imagen->save();
        return redirect()->route('imagen_productos.index')->with('success', 'Imagen de producto actualizada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $imagen = \App\Models\Imagen::findOrFail($id);
        $imagen->delete();
        return redirect()->route('imagen_productos.index')->with('success', 'Imagen de producto eliminada correctamente');

    }
}
