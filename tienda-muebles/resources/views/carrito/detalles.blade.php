@extends('layout.app')

@section('content')
<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-2">
                <i class="bi bi-box-seam"></i> Detalles del Pedido #{{ $carrito->id }}
            </h2>
            <p class="text-muted mb-4">
                <small>
                    Fecha: {{ $carrito->created_at->format('d de F de Y \a \l\a\s H:i') }}
                    | Sesión: {{ substr($carrito->sesion_id, 0, 20) }}...
                </small>
            </p>

            <div class="row">
                {{-- Tabla de items --}}
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Productos del Pedido</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Iterar sobre items del carrito --}}
                                    @foreach ($carrito->items as $item)
                                        <tr>
                                            {{-- Nombre del producto --}}
                                            <td>
                                                <strong>{{ $item->producto->nombre }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    Producto ID: {{ $item->producto_id }}
                                                </small>
                                            </td>

                                            {{-- Cantidad --}}
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $item->cantidad }}
                                                </span>
                                            </td>

                                            {{-- Precio unitario --}}
                                            <td>
                                                <span class="badge bg-info">
                                                    ${{ number_format($item->precio_unitario, 2) }}
                                                </span>
                                            </td>

                                            {{-- Subtotal (cantidad * precio unitario) --}}
                                            <td>
                                                <strong class="text-success">
                                                    ${{ number_format($item->cantidad * $item->precio_unitario, 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Resumen de cálculos --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Resumen del Pedido</h5>
                        </div>
                        <div class="card-body">
                            {{-- Información del usuario --}}
                            <div class="mb-3 pb-3 border-bottom">
                                <small class="text-muted">Cliente:</small><br>
                                <strong>{{ $carrito->user->name }}</strong><br>
                                <small class="text-muted">{{ $carrito->user->email }}</small>
                            </div>

                            {{-- Cálculos --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <strong>${{ number_format($subtotal, 2) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Impuestos (10%):</span>
                                <strong class="text-warning">${{ number_format($impuestos, 2) }}</strong>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <h6>Total del Pedido:</h6>
                                <h5 class="text-success">
                                    ${{ number_format($total, 2) }}
                                </h5>
                            </div>

                            {{-- Información adicional --}}
                            <div class="mt-4 pt-3 border-top">
                                <small class="text-muted">
                                    <strong>Creado:</strong> {{ $carrito->created_at->diffForHumans() }}<br>
                                    <strong>Actualizado:</strong> {{ $carrito->updated_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones de navegación --}}
            <div class="mt-4">
                <a href="{{ route('carrito.historial') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al Historial
                </a>
                <a href="{{ route('carrito.index') }}" class="btn btn-primary">
                    <i class="bi bi-bag"></i> Ir al Carrito
                </a>
                <a href="{{ route('productos.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-shop"></i> Continuar Comprando
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
