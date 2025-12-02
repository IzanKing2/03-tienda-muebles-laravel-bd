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
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 2px #33261ba8;
        background-color: #f9f9f9;
        font-family: Arial, sans-serif;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 25px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    button,
    form a {
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
        font-weight: bold;
    }

    button[type="submit"] {
        background-color: #0079cf;
        color: white;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    form a {
        background-color: #7c542d;
        color: white;
    }

    form a:hover {
        background-color: #7e4c1a;
    }

    form > .button-group {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 20px;
    }
</style>

@section('content')
<div>
    <h2>Editar Producto</h2>

    <form action="{{ route('products.update', $producto) }}" method="POST" enctype="multipart/form-data">
        <div class="button-group">
            @csrf
            @method('PUT')
            @include('products.form', ['producto' => $producto])
            <button type="submit">Actualizar</button>
            <a href="{{ route('productos.index') }}">Volver</a>
        </div> 
    </form>
</div>
@endsection