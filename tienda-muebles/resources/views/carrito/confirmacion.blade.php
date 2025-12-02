@extends('layout')
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
        
    .contenedor-compra {
        max-width: 800px;
        margin: 40px auto; 
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        background-color: #ffffff;
    }

    .contenedor-compra h2 {
        text-align: center;
        color: #333;
        margin-bottom: 5px;
        font-size: 2em;
        padding-bottom: 10px;
    }

    .contenedor-compra > p:first-of-type {
        text-align: center;
        color: #555;
        font-size: 1.1em;
        margin-bottom: 20px;
    }

    .contenedor-compra table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .contenedor-compra th, .contenedor-compra td {
        padding: 8px 8px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .contenedor-compra thead th {
        background-color: #f8f8f8;
        color: #333;
        font-weight: bold;
        border-top: 2px solid #ddd;
        border-bottom: 2px solid #ddd;
    }

    .contenedor-compra tbody tr:hover {
        background-color: #f0f8ff;
    }

    .contenedor-compra td:nth-child(3),
    .contenedor-compra td:nth-child(4),
    .contenedor-compra td:nth-child(5) {
        text-align: right;
    }

    .contenedor-compra table img {
        max-width: 60px;
        height: auto;
        border-radius: 4px;
        vertical-align: middle;
    }

    .contenedor-compra > div:nth-of-type(2) {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 30px;
    }

    .contenedor-compra > div:nth-of-type(2) > div {
        width: 100%;
        max-width: 300px;
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #eee;
        border-radius: 6px;
    }

    .contenedor-compra > div:nth-of-type(2) p {
        display: flex;
        justify-content: space-between;
        margin: 5px 0;
        font-size: 1.1em;
        color: #333;
    }


    .contenedor-compra > div:nth-of-type(2) p:last-child {
        font-size: 1.2em;
        font-weight: bold;
        border-top: 1px dashed #ccc;
        padding-top: 10px;
        margin-top: 10px;
    }

    .contenedor-compra a > button {
        width: 250px;
        margin: 0 auto;
        padding: 12px 20px;
        background-color: #5c4033;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .contenedor-compra a > button:hover {
        background-color: #7b5b4e;
    }
</style>

@section('content')
<div class="contenedor-compra">
    <h2>Confirmación de compra</h2>
    <p>Gracias por su compra</p>
    
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Imagen</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item ['nombre'] }}</td>
                <td>
                    @if $item['imagen']
                        <img src="{{ asset('storage/' . $item['imagen']) }}">
                    @else
                        <span>No hay imagenes</span>
                    @endif
                </td>
                <td>{{ $item ['cantidad'] }}</td>
                <td>{{ number_format($item['precio'], 2) }}€</td>
                <td>{{ number_format($item['precio'] * $item['cantidad'], 2)}}€</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <div>
            <p>Subtotal: <span>{{ number_format($subtotal, 2) }} €</span></p>
            <p>Impuestos (10%): <span>{{ number_format($impuestos, 2) }} €</span></p>
            <p>Total: <span>{{ number_format($total, 2) }} €</span></p>
        </div>
    </div>

    <div>
        <a href="{{ route('home') }}">
            <button type="button">Volver al Inicio</button>
        </a>
    </div>
</div>
@endsection