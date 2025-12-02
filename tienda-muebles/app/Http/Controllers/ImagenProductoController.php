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
            'url_imagen'  => 'required_without:archivo|nullable|url',
            'archivo'     => 'required_without:url_imagen|nullable|image|max:2048',
        ]);

        $imagen = new Imagen();
        $imagen->producto_id = $request->producto_id;

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('productos', 'public');
            $imagen->url_imagen = Storage::url($path);
        } else {
            $imagen->url_imagen = $request->url_imagen;
        }

        $imagen->save();

        return redirect()->route('imagen_productos.index')->with('success', 'Imagen de producto creada correctamente');
    }

    public function show(Imagen $imagen)
    {
        return view('imagen_productos.show', compact('imagen'));
    }

    public function edit(Imagen $imagen)
    {
        $productos = Producto::orderBy('nombre')->pluck('nombre', 'id');
        return view('imagen_productos.edit', compact('imagen', 'productos'));
    }

    public function update(Request $request, Imagen $imagen)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'url_imagen'  => 'required_without:archivo|nullable|url',
            'archivo'     => 'required_without:url_imagen|nullable|image|max:2048',
        ]);

        $imagen->producto_id = $request->producto_id;

        if ($request->hasFile('archivo')) {
            // opcional: eliminar archivo anterior si se guardó localmente
            $path = $request->file('archivo')->store('productos', 'public');
            $imagen->url_imagen = Storage::url($path);
        } else {
            $imagen->url_imagen = $request->url_imagen;
        }

        $imagen->save();

        return redirect()->route('imagen_productos.index')->with('success', 'Imagen de producto actualizada correctamente');
    }

    public function destroy(Imagen $imagen)
    {
        // opcional: borrar archivo físico si procede
        $imagen->delete();
        return redirect()->route('imagen_productos.index')->with('success', 'Imagen de producto eliminada correctamente');
    }
}
