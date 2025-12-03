@extends('layout.cabecera')
<style>
    * {
        font-family: Arial, sans-serif;
    }

    body {
        background-color: #976f47;
    }

    div {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px 30px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px #33261ba8;
        font-family: Arial, sans-serif;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 25px;
        border-bottom: 2px solid #ddd;
        padding-bottom: 10px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    form button,
    form a {
        display: inline-block;
        padding: 10px 15px;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
    }

    form button[type="submit"] {
        background-color: #0079cf;
        color: white;
        border: none;
    }

    form button[type="submit"]:hover {
        background-color: #0056b3;
    }

    form a {
        background-color: #7c542d;
        color: white;
        border: 1px solid #7c542d;
    }

    form a:hover {
        background-color: #7e4c1a;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #555;
    }

    select,
    input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
</style>

@section('content')
    <div>
        <h2>Nueva Imagen de Galería</h2>

        <form action="{{ route('imagen_productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="producto_id">Producto</label>
                <select name="producto_id" id="producto_id" required>
                    <option value="">-- Seleccionar Producto --</option>
                    @foreach($productos as $id => $nombre)
                        <option value="{{ $id }}">{{ $nombre }}</option>
                    @endforeach
                </select>
                @error('producto_id')
                    <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="archivo">Imagen</label>
                <input type="file" name="archivo" id="archivo" accept="image/*" required>
                @error('archivo')
                    <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Guardar</button>
            <a href="{{ route('imagen_productos.index') }}">Volver</a>
        </form>
    </div>
@endsection