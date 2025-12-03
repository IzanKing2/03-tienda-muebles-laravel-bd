<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Imagen;
use App\Models\Producto;

class ImagenProductoController extends Controller
{
    public function index()
    {
        $imagenes = Imagen::with('producto')->orderBy('id', 'desc')->paginate(10);
        return view('imagen_productos.index', compact('imagenes'));
    }

    public function create()
    {
        $productos = Producto::orderBy('nombre')->pluck('nombre', 'id');
        return view('imagen_productos.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'archivo' => 'required|image|max:2048',
        ]);

        // Buscar o crear galería para el producto
        $galeria = \App\Models\Galeria::firstOrCreate(['producto_id' => $request->producto_id]);

        $imagen = new Imagen();
        $imagen->galeria_id = $galeria->id;

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('galerias', 'public');
            $imagen->ruta = $path; // Guardar solo la ruta relativa
        }

        $imagen->save();

        return redirect()->route('imagen_productos.index')->with('success', 'Imagen de producto creada correctamente');
    }

    public function show(Imagen $imagenProducto)
    {
        return view('imagen_productos.show', ['imagen' => $imagenProducto]);
    }

    public function edit(Imagen $imagenProducto)
    {
        $productos = Producto::orderBy('nombre')->pluck('nombre', 'id');
        return view('imagen_productos.edit', ['imagen' => $imagenProducto, 'productos' => $productos]);
    }

    public function update(Request $request, Imagen $imagenProducto)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'archivo' => 'nullable|image|max:2048',
        ]);

        // Si cambia el producto, cambiar la galería
        if ($imagenProducto->galeria->producto_id != $request->producto_id) {
            $galeria = \App\Models\Galeria::firstOrCreate(['producto_id' => $request->producto_id]);
            $imagenProducto->galeria_id = $galeria->id;
        }

        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior
            $imagenProducto->eliminarArchivo();

            $path = $request->file('archivo')->store('galerias', 'public');
            $imagenProducto->ruta = $path;
        }

        $imagenProducto->save();

        return redirect()->route('imagen_productos.index')->with('success', 'Imagen de producto actualizada correctamente');
    }

    public function destroy(Imagen $imagenProducto)
    {
        // opcional: borrar archivo físico si procede
        $imagenProducto->delete();
        return redirect()->route('imagen_productos.index')->with('success', 'Imagen de producto eliminada correctamente');
    }
}
