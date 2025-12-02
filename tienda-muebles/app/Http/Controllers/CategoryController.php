<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = \App\Models\Categoria::all();
        return view('categories.index', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = \App\Models\Categoria::all();
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias',
        ]);
        $category = new \App\Models\Categoria();
        $category->nombre = $request->nombre;
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Categoría creada correctamente');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = \App\Models\Categoria::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $category = \App\Models\Categoria::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $id,
        ]);
        $category = \App\Models\Categoria::findOrFail($id);
        $category->nombre = $request->nombre;
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Categoría actualizada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = \App\Models\Categoria::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada correctamente');
        
    }
}
