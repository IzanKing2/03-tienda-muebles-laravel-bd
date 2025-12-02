@extends('layout.cabecera')
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
    }

    body {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #976f47;
        color: #000;
    }

    div {
        max-width: 1100px;
        margin: 40px auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #333;
    }

    .alert {
        padding: 12px 18px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    div>a {
        display: inline-block;
        padding: 10px 16px;
        background: #7c542d;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        margin-bottom: 20px;
        font-weight: bold;
        transition: 0.3s ease;
    }

    div>a:hover {
        background: #7e4c1a;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 0.95rem;
    }

    thead {
        background: #4b3828;
        color: white;
    }

    thead th {
        padding: 12px;
        text-align: left;
    }

    tbody tr {
        border-bottom: 1px solid #ddd;
    }

    tbody tr:hover {
        background: #f1f1f1;
    }

    td {
        padding: 12px;
    }

    td img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    td a {
        display: inline-block;
        padding: 6px 10px;
        background: #07deff;
        color: #000;
        border-radius: 4px;
        text-decoration: none;
        margin-right: 8px;
        font-size: 0.9rem;
    }

    td a:hover {
        background: #06c4e1;
    }

    td form button {
        padding: 6px 10px;
        background: #d82336;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: 0.2s ease;
    }

    td form button:hover {
        background: #af1f2e;
    }

    td form {
        display: inline;
    }
</style>

@section('content')
    <div>
        <h2>Listado de Productos</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('productos.create') }}">Nuevo Producto</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->nombre }}</td>
                        <td>{{ $p->categoria_id }}</td>
                        <td>{{ $p->precioFormateado }}</td>
                        <td>{{ $p->stock }}</td>
                        <td>
                            @if ($p->imagen)
                                <img src="{{ asset($p->imagen) }}">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('productos.edit', $p) }}">Editar</a>
                            <form action="{{ route('productos.destroy', $p) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection