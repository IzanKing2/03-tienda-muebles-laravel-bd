<style>
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #555;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 1rem;
        transition: border-color 0.3s, box-shadow 0.3s;
        background-color: #fff;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    textarea:focus,
    select:focus {
        border-color: #7c542d;
        outline: none;
        box-shadow: 0 0 0 3px rgba(124, 84, 45, 0.1);
    }

    textarea {
        resize: vertical;
        min-height: 120px;
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .image-preview {
        margin-top: 15px;
        padding: 10px;
        border: 1px dashed #ccc;
        border-radius: 6px;
        display: inline-block;
        background-color: #fff;
    }
    
    .image-preview img {
        max-width: 150px;
        border-radius: 4px;
        display: block;
    }
</style>

<div class="form-grid">
    <div class="form-group full-width">
        <label for="nombre">Nombre del Producto</label>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $product->nombre ?? '') }}" required placeholder="Ej: Mesa de Comedor Roble">
    </div>

    <div class="form-group full-width">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" placeholder="Describe los detalles del producto...">{{ old('descripcion', $product->descripcion ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label for="precio">Precio (€)</label>
        <input type="number" id="precio" name="precio" step="0.01" value="{{ old('precio', $product->precio ?? '') }}" required placeholder="0.00">
    </div>

    <div class="form-group">
        <label for="stock">Stock Disponible</label>
        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required placeholder="0">
    </div>

    <div class="form-group full-width">
        <label for="categoria_id">Categoría</label>
        <select id="categoria_id" name="categoria_id">
            <option value="">-- Seleccionar Categoría --</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" @selected(old('categoria_id', $product->categoria_id ?? '') == $categoria->id)>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group full-width">
        <label for="imagen">Imagen del Producto</label>
        <input type="file" id="imagen" name="imagen" accept="image/*">
        
        @if (!empty($product->imagen))
            <div class="image-preview">
                <p style="margin-top: 0; font-size: 0.9em; color: #666; margin-bottom: 5px;">Imagen actual:</p>
                <img src="{{ asset($product->imagen) }}" alt="Imagen actual">
            </div>
        @endif
    </div>
</div>