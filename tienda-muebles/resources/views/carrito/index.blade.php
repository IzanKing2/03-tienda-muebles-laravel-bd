@extends('layout.cabecera')
<style>
    * {
        font-family: 'Arial', sans-serif;
    }
    
    body {
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
        padding: 12px 6px;
        text-align: left;
    }

    td button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 10px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        line-height: 1;
    }

    td button[title="Actualizar cantidad"] {
        background-color: #0079cf;
    }

    td button[title="Actualizar cantidad"]:hover {
        background-color: #0056b3;
    }

    td button[title="Eliminar producto"] {
        background-color: #d82336;
    }

    td button[title="Eliminar producto"]:hover {
        background-color: #af1f2e;
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
<div class="container mt-5 mb-5">
  <h2>Carrito de Compra</h2>

  {{-- Mensajes flash --}}
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @elseif (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

        @if (empty($carrito))
            <div>
                <p>El carro está vacío</p>
                <a href="{{ route('home') }}">
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
                    @foreach($carrito as $id => $item)
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
                            <td>
                                <div>
                                    <form action="{{ route('carrito.update', $id) }}" method="POST">
                                        @csrf
                                        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1">
                                        <button type="submit" title="Actualizar cantidad">Actualizar</button>
                                    </form>
                                    <form action="{{ route('carrito.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Eliminar producto">Eliminar Producto</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

    {{-- Resumen del pedido --}}
    <div class="row">
      <div class="col-md-4 offset-md-8">
        <div class="card">
          <div class="card-body">
            <p>Subtotal: {{ number_format($subtotal, 2) }} €</p>
            <p>Impuestos (10%): {{ number_format($impuestos, 2) }} €</p>
            <p><strong>Total: {{ number_format($total, 2) }} €</strong></p>
            @auth
              <form action="{{ route('carrito.guardar') }}" method="POST" class="mb-2">
                @csrf
                <button type="submit" class="btn btn-success w-100">
                  <i class="bi bi-check-circle"></i> Confirmar Pedido
                </button>
              </form>
            @else
              <a href="{{ route('login') }}" class="btn btn-success w-100 mb-2">
                <i class="bi bi-box-arrow-in-right"></i> Inicia sesión para comprar
              </a>
            @endauth
            <form action="{{ route('carrito.vaciar') }}" method="POST">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('¿Deseas vaciar el carrito?')">
                <i class="bi bi-trash"></i> Vaciar Carrito
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection
