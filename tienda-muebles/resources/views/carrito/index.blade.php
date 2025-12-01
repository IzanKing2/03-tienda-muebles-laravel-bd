@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('success'))
        <div>
            {{ session('success') }}
            <button type="button" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div>
            {{ session('error') }}
            <button type="button" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (empty($carrito))
    <div>
        <p>El carro está vacío</p>
        <a href="{{ route ('') }}">
            <i></i>Ir a la Tienda
        </a>
    </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Imagen</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th>Acciones<th>
                </tr>
            </thead>

            <tbody>
                @foreach($carrito as $item)
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
                        <td><a></a></td>
                    </tr>
                    @endforeach
            </tbody>
        </table>

        <div>
            <p>Subtotal: <span>{{ number_format($total, 2) }} €</span></p>
            <p>Impuestos: <span>{{ number_format($total*0.10, 2) }} €</span></p>
            <p>Total: <span>{{ number_format($total + ($total*0.10), 2) }} €</span></p>
        </div>

        <div>
            <a href="#">
                <button type="button">Finalizar compra</button>
            </a>
        </div>
    @endif
</div>
@endsection


