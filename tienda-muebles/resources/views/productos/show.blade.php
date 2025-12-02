@extends('layout.cabecera')
<style>
    .contenedor-producto {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: sans-serif;
        color: #333;
    }

    .contenedor-producto nav ol {
        list-style: none;
        padding: 0;
        margin-bottom: 20px;
        display: flex;
    }

    .contenedor-producto nav ol li {
        margin-right: 10px;
        font-size: 0.9em;
    }

    .contenedor-producto nav ol li:not(:last-child)::after {
        content: ' / ';
        margin-left: 10px;
        color: #999;
    }

    .contenedor-producto nav ol li a {
        color: #007bff;
        text-decoration: none;
    }

    .contenedor-producto nav ol li:last-child {
        color: #6c757d;
    }

    .contenido-principal {
        display: flex;
        gap: 40px;
        margin-bottom: 40px;
    }

    .seccion-imagenes {
        flex: 1;
        max-width: 50%;
    }

    .imagen-principal {
        border: 1px solid #ddd;
        margin-bottom: 10px;
        padding: 5px;
    }

    .imagen-principal img {
        width: 100%;
        height: auto;
        display: block;
    }

    .galeria-miniatura {
        display: flex;
        gap: 10px;
        overflow-x: auto;
    }

    .galeria-miniatura img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 1px solid #ddd;
        cursor: pointer;
        transition: transform 0.2s, border-color 0.2s;
    }

    .galeria-miniatura img:hover {
        border-color: #007bff;
        transform: scale(1.05);
    }

    .seccion-info {
        flex: 1;
    }

    .seccion-info h1 {
        font-size: 2.2em;
        margin-top: 0;
        margin-bottom: 5px;
        color: #333;
    }

    .seccion-info p {
        margin: 5px 0;
        line-height: 1.5;
    }

    .seccion-info h3 {
        color: #28a745;
        font-size: 1.8em;
        margin: 15px 0;
    }

    .seccion-info .stock-info {
        font-weight: bold;
        color: #17a2b8;
    }

    .seccion-info .sin-stock {
        color: #dc3545;
        font-weight: bold;
    }

    .seccion-info form button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 12px 25px;
        font-size: 1.1em;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
        margin-top: 20px;
    }

    .seccion-info form button:hover {
        background-color: #0056b3;
    }

    .contenedor-producto hr {
        border: 0;
        border-top: 1px solid #eee;
        margin: 30px 0;
    }

    .contenedor-producto h3 {
        font-size: 1.5em;
        margin-bottom: 15px;
    }

    .contenedor-producto ul {
        list-style: none;
        padding: 0;
    }

    .contenedor-producto ul li {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px dashed #eee;
    }

    .contenedor-producto ul li:last-child {
        border-bottom: none;
    }

    .contenedor-producto ul li strong {
        font-weight: 600;
        width: 30%;
        color: #555;
    }

    .contenedor-producto ul li span {
        width: 65%;
        text-align: right;
    }

    @media (max-width: 768px) {
        .contenido-principal {
            flex-direction: column;
        }

        .seccion-imagenes,
        .seccion-info {
            max-width: 100%;
        }

        .seccion-info h1 {
            font-size: 1.8em;
        }
    }
</style>

@section('content')
    <div class="contenedor-producto">

        <nav>
            <ol>
                <li><a href="{{ route('productos.index') }}">Muebles</a></li>
                <li>{{ $producto->nombre }}</li>
            </ol>
        </nav>

        <div class="contenido-principal">
            <div class="seccion-imagenes">
                <div class="imagen-principal">
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                </div>

                @if(isset($producto->galeria) && count($producto->galeria))
                    <div class="galeria-miniatura">
                        @foreach($producto->galeria as $img)
                            <img src="{{ asset('storage/' . $img) }}" width="80" alt="Galería de {{ $producto->nombre }}">
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="seccion-info">
                <h1>{{ $producto->nombre }}</h1>

                <p class="categoria">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
                <h3>${{ number_format($producto->precio, 2) }}</h3>
                <p class="descripcion">{{ $producto->descripcion }}</p>

                @if($producto->stock > 0)
                    <p class="stock-info">En stock: {{ $producto->stock }}</p>
                @else
                    <p class="sin-stock">Sin stock</p>
                @endif

                @if($producto->stock > 0)
                    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                        @csrf
                        <button type="submit">Añadir al carrito</button>
                    </form>
                @endif
            </div>
        </div>

        <hr>

        @if(isset($producto->especificaciones))
            <h3>Especificaciones</h3>
            <ul class="lista-especificaciones">
                @foreach($producto->especificaciones as $key => $value)
                    <li>
                        <strong>{{ ucfirst($key) }}</strong>
                        <span>{{ $value }}</span>
                    </li>
                @endforeach
            </ul>
        @endif

    </div>
@endsection