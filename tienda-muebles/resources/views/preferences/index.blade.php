@extends('layout')

@section('content')

    <div class="container">
        <h2>Preferencias</h2>

        @if(session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ auth()->check() ? route('preferences.update') : route('preferences.cookie') }}" method="POST">
            @csrf
            @if(auth()->check())
                @method('PUT')
            @endif
            
            <label for="tema">Tema:</label>
            <select name="tema" id="tema">
                <option value="light" {{ $preferencias->tema === 'light' ? 'selected' : '' }}>Claro</option>
                <option value="dark" {{ $preferencias->tema === 'dark' ? 'selected' : '' }}>Oscuro</option>
            </select>

            <label for="moneda">Moneda:</label>
            <select name="moneda" id="moneda">
                <option value="€" {{ $preferencias->moneda === '€' ? 'selected' : '' }}>€</option>
                <option value="$" {{ $preferencias->moneda === '$' ? 'selected' : '' }}>$</option>
                <option value="£" {{ $preferencias->moneda === '£' ? 'selected' : '' }}>£</option>
            </select>

            <label for="paginacion">Paginación:</label>
            <select name="paginacion">
                <option value="6" {{ $preferencias->paginacion === 6 ? 'selected' : '' }}>6</option>
                <option value="12" {{ $preferencias->paginacion === 12 ? 'selected' : '' }}>12</option>
                <option value="24" {{ $preferencias->paginacion === 24 ? 'selected' : '' }}>24</option>
                <option value="48" {{ $preferencias->paginacion === 48 ? 'selected' : '' }}>48</option>
            </select>

            <button type="submit">Guardar</button>
        </form>
    </div>
@endsection