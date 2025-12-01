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
        <a href="{{ route ('productos.index') }}">
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
                        @if $item['imagen'] *mejorar
                            <img>
                        @else
                            <span>No hay imagenes</span>
                        @endif
                        </td>
                        <td>{{ $item ['cantidad'] }}</td>
                        <td>{{ number_format($item['precio'], 2) }}€</td>
                        <td>{{ number_format($item['precio'] * $item['cantidad'], 2)}}€<</td>
                        <td><a></a></td>
                    </tr>
                    @endforeach
            </tbody>
        </table>

        <div>
            <p>Subtotal: <span>{{ number_format($total, 2) }} €</span></p>
            <p>Impuestos: </p>
            <p>Total: </p>
        </div>
        <div>
            <a href="#">Finalizar compra</a>
        </div>
    @endif
</div>
@endsection


