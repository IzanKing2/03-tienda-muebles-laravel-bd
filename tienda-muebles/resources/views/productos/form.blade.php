<style>
    body {
        background-color: #976f47;
    }

    div {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px; 
        background-color: #f9f9f9;
        font-family: Arial, sans-serif;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    textarea:focus,
    select:focus {
        border-color: #7c542d;
        outline: none;
        box-shadow: 0 0 5px #33261ba8;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    form > div > img {
        margin-top: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        display: block;
    }
</style>

<div>
    <label>Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre ?? '') }}" required>
</div>

<div>
    <label>Descripción</label>
    <textarea name="descripcion">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
</div>

<div>
    <label>Precio (€)</label>
    <input type="number" name="precio" step="0.01" value="{{ old('precio', $producto->precio ?? '') }}" required>
</div>

<div>
    <label>Stock</label>
    <input type="number" name="stock" value="{{ old('stock', $producto->stock ?? '') }}" required>
</div>

<div>
    <label>Categoría</label>
    <select name="categoria_id">
        <option value="">-- Sin categoría --</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id }}" @selected(old('categoria_id', $producto->categoria_id ?? '') == $categoria->id)>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label>Imagen</label>
    <input type="file" name="imagen">
    @if (!empty($producto->imagen))
        <img src="{{ asset($producto->imagen) }}" width="80">
    @endif
</div>