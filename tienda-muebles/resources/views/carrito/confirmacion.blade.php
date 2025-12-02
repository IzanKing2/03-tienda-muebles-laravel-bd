@extends('layouts.app')

@section('content')
<div>
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

    <div class="parrafoagradecimiento">
        <p>Gracias por la compra. En breve recíbira sus articulos</p>
    </div>

    <div>
        <a href="{{ route('home') }}">
            <button type="button">Volver al Inicio</button>
        </a>
    </div>
</div>
@endsection