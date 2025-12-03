@extends('layout.cabecera')

@section('content')
<div class="container mt-5 mb-5">
  <h2>Carrito de Compra</h2>

  {{-- Mensajes flash --}}
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @elseif (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  {{-- Carrito vacío --}}
  @if (empty($carrito))
    <div class="alert alert-info text-center py-5">
      <i class="bi bi-bag" style="font-size: 3rem;"></i>
      <p class="mt-3">Tu carrito está vacío.</p>
      <a href="{{ route('productos.index') }}" class="btn btn-primary">
        <i class="bi bi-shop"></i> Ir a la tienda
      </a>
    </div>
  @else
    {{-- Tabla de productos --}}
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Precio Unitario</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($carrito as $id => $item)
          <tr>
            <td>{{ $item['nombre'] }}</td>
            <td>{{ number_format($item['precio'], 2) }} €</td>
            <td>
              <form action="{{ route('carrito.actualizar') }}" method="POST" class="d-flex">
                @csrf @method('PUT')
                <input type="hidden" name="producto_id" value="{{ $id }}">
                <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" class="form-control form-control-sm" style="width: 80px;">
                <button type="submit" class="btn btn-sm btn-warning ms-2">
                  <i class="bi bi-arrow-repeat"></i>
                </button>
              </form>
            </td>
            <td>{{ number_format($item['precio'] * $item['cantidad'], 2) }} €</td>
            <td>
              <form action="{{ route('carrito.eliminar', $id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                  <i class="bi bi-trash"></i> Eliminar
                </button>
              </form>
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
