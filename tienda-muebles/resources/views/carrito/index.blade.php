@extends('layout.cabecera')
<style>
    * {
        font-family: 'Arial', sans-serif;
    }
    
        body {
        font-family: var(--font-family-sans);
        background-color: #f8f9fa;
        color: var(--color-text-dark);
        margin: 0;
        padding: 0;
        background-color: #976f47;
    }

    .container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px #33261ba8;
    }

    .container > div:has(button[data-bs-dismiss="alert"]) {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
    }

    .container > div:has(button[data-bs-dismiss="alert"]):first-child { 
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .container > div:has(button[data-bs-dismiss="alert"]):nth-child(2) { 
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .container button[data-bs-dismiss="alert"] {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: inherit;
        opacity: 0.5;
        line-height: 1;
        padding: 0;
    }

    .container button[data-bs-dismiss="alert"]::after {
        content: "×";
    }

    .container > div:first-child:not(:has(button[data-bs-dismiss="alert"])) {
        text-align: center;
        padding: 50px 20px;
        border: 2px dashed var(--color-border);
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .container > div:first-child:not(:has(button[data-bs-dismiss="alert"])) p {
        font-size: 1.25rem;
        margin-bottom: 15px;
        color: var(--color-text-dark);
    }

    .container > div:first-child:not(:has(button[data-bs-dismiss="alert"])) a {
        background-color: #5c4033;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
        display: inline-flex;
        align-items: center;
    }

    .container > div:first-child:not(:has(button[data-bs-dismiss="alert"])) a:hover {
        background-color: #7b5b4e;
    }

    .container > div:first-child:not(:has(button[data-bs-dismiss="alert"])) i {
        margin-right: 8px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        background-color: #fff;
    }

    thead {
        background-color: #4b3828;
        color: #fff;
    }

    th, td {
        padding: 12px 12px;
        text-align: left;
        border-bottom: 1px solid var(--color-border);
    }

    th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    tbody tr:hover {
        background-color: #f1f1f1;
    }

    td img {
        max-width: 80px;
        height: auto;
        border-radius: 4px;
        display: block;
    }

    td span {
        color: #6c757d;
        font-size: 0.8rem;
    }

    .container > div:nth-last-child(2):not(:has(a)) {
        width: 100%;
        max-width: 300px;
        margin-left: auto;
        padding: 15px;
        border: 1px solid var(--color-border);
        border-radius: 4px;
        background-color: #f8f9fa;
    }

    .container > div:nth-last-child(2):not(:has(a)) p {
        display: flex;
        justify-content: space-between;
        margin: 5px 0;
        padding: 3px 0;
    }

    .container > div:nth-last-child(2):not(:has(a)) p:last-child {
        font-weight: bold;
        padding-top: 10px;
        margin-top: 10px;
        font-size: 1.1rem;
    }

    .container > div:nth-last-child(2):not(:has(a)) span {
        font-weight: normal;
    }

    .container > div:last-child {
        text-align: right;
        margin-top: 20px;
    }

    .container > div:last-child button {
        background-color: #5c4033;
        color: #fff;
        border: none;
        padding: 12px 25px;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-weight: bold;
    }

    .container > div:last-child button:hover {
        background-color: #7b5b4e;
    }
</style>

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
                <a href="{{ route('productos.show') }}">
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
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($carrito as $item)
                        <tr>
                            <td>{{ $item['nombre'] }}</td>
                            <td>
                                @if ($item['imagen'])
                                    <img src="{{ asset('storage/' . $item['imagen']) }}">
                                @else
                                    <span>No hay imagenes</span>
                                @endif
                            </td>
                            <td>{{ $item['cantidad'] }}</td>
                            <td>{{ number_format($item['precio'], 2) }}€</td>
                            <td>{{ number_format($item['precio'] * $item['cantidad'], 2)}}€</td>
                            <td><a></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                <p>Subtotal: <span>{{ number_format($total, 2) }} €</span></p>
                <p>Impuestos: <span>{{ number_format($total * 0.10, 2) }} €</span></p>
                <p>Total: <span>{{ number_format($total + ($total * 0.10), 2) }} €</span></p>
            </div>

            <div>
                <a href="#">
                    <button type="button">Finalizar compra</button>
                </a>
            </div>
        @endif
    </div>
@endsection