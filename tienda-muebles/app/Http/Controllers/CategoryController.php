<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // paginación en lugar de traer todo
        $categories = Categoria::orderBy('nombre')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // no hace falta cargar todas las categorías para crear una nueva
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
        ]);

        $category = new Categoria();
        $category->nombre = $request->nombre;
        $category->save();

        return redirect('/categories')->with('success', 'Categoría creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $category)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $category->id,
        ]);

        $category->nombre = $request->nombre;
        $category->save();

        return redirect('/categories')->with('success', 'Categoría actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $category)
    {
        // Verificar si la categoría tiene productos
        if ($category->productos()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'No se puede eliminar una categoría que tiene productos asociados');
        }

        $category->delete();
        return redirect('/categories')->with('success', 'Categoría eliminada correctamente');
    }
}
