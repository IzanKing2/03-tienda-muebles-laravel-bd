<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with('categorias')->orderBy('nombre')->paginate(10);
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->pluck('nombre', 'id');
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150|unique:productos,nombre',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'materiales' => 'required|string',
            'dimensiones' => 'required|string|max:100',
            'color_principal' => 'required|string|max:50',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->materiales = $request->materiales;
        $producto->dimensiones = $request->dimensiones;
        $producto->color_principal = $request->color_principal;
        $producto->precio = $request->precio;
        // $producto->categoria_id = $request->categoria_id; // Remove this
        $producto->save();

        // Guardar relación con categoría
        $producto->categorias()->sync([$request->categoria_id]);

        return redirect('/products')->with('success', 'Producto creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $product)
    {
        $product->load('categorias');
        return view('productos.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $product)
    {
        $categorias = Categoria::orderBy('nombre')->pluck('nombre', 'id');
        return view('productos.edit', compact('product', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $product)
    {
        $request->validate([
            'nombre' => 'required|string|max:150|unique:productos,nombre,' . $product->id,
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $product->nombre = $request->nombre;
        $product->descripcion = $request->descripcion;
        $product->precio = $request->precio;
        $product->stock = $request->stock;
        $product->materiales = $request->materiales;
        $product->dimensiones = $request->dimensiones;
        $product->color_principal = $request->color_principal;
        // $product->categoria_id = $request->categoria_id; // Remove this
        $product->save();

        // Actualizar relación con categoría
        $product->categorias()->sync([$request->categoria_id]);

        return redirect('/products')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $product)
    {
        $product->delete();
        return redirect('/products')->with('success', 'Producto eliminado correctamente');
    }
}
