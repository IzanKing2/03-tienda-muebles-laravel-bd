@extends('layout.app')

@section('content')
<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">
                <i class="bi bi-clock-history"></i> Historial de Pedidos
            </h2>

            @if ($carritos->count() > 0)
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Pedido</th>
                                    <th>Fecha</th>
                                    <th>Sesión ID</th>
                                    <th>Nº Items</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Iterar sobre cada carrito guardado --}}
                                @foreach ($carritos as $carrito)
                                    <tr>
                                        {{-- ID del pedido --}}
                                        <td>
                                            <span class="badge bg-primary">#{{ $carrito->id }}</span>
                                        </td>

                                        {{-- Fecha de creación --}}
                                        <td>
                                            <small class="text-muted">
                                                {{ $carrito->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </td>

                                        {{-- ID de sesión (información de qué pestaña/navegador) --}}
                                        <td>
                                            <code class="text-muted" style="font-size: 0.85rem;">
                                                {{ substr($carrito->sesion_id, 0, 12) }}...
                                            </code>
                                        </td>

                                        {{-- Número de items --}}
                                        <td>
                                            <span class="badge bg-info">{{ $carrito->items->count() }}</span>
                                        </td>

                                        {{-- Total del pedido --}}
                                        <td>
                                            <strong class="text-success">
                                                ${{ number_format($carrito->total, 2) }}
                                            </strong>
                                        </td>

                                        {{-- Botón ver detalles --}}
                                        <td>
                                            <a
                                                href="{{ route('carrito.detalles', $carrito->id) }}"
                                                class="btn btn-sm btn-info"
                                                title="Ver detalles del pedido"
                                            >
                                                <i class="bi bi-eye"></i> Detalles
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Paginación --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $carritos->links() }}
                </div>
            @else
                {{-- Si no hay pedidos --}}
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                    <p class="mt-3">No tienes pedidos guardados</p>
                    <a href="{{ route('productos.index') }}" class="btn btn-primary">
                        <i class="bi bi-shop"></i> Empezar a Comprar
                    </a>
                </div>
            @endif

            {{-- Botón volver --}}
            <div class="mt-4">
                <a href="{{ route('carrito.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al Carrito
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
