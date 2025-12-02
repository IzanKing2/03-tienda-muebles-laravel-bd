@extends('layout')

@section('content')

    <div class="container">
        <h2>Preferencias</h2>

        <form action="{{ auth()->check() ? route('preferences.update') : route('preferences.cookie') }}" method="POST">
            
            <label for="tema">Tema:</label>
            <select name="tema" id="tema">
                <option value="light" {{ $preferences->tema === 'light' ? 'selected' : '' }}>Claro</option>
                <option value="dark" {{ $preferences->tema === 'dark' ? 'selected' : '' }}>Oscuro</option>
            </select>

            <label for="moneda">Moneda:</label>
            <select name="moneda" id="moneda">
                <option value="€" {{ $preferences->moneda === '€' ? 'selected' : '' }}>€</option>
                <option value="$" {{ $preferences->moneda === '$' ? 'selected' : '' }}>$</option>
                <option value="£" {{ $preferences->moneda === '£' ? 'selected' : '' }}>£</option>
            </select>

            <label for="paginacion">Paginación:</label>
            <select name="paginacion">
                <option value="6" {{ $preferences->paginacion === 6 ? 'selected' : '' }}>6</option>
                <option value="12" {{ $preferences->paginacion === 12 ? 'selected' : '' }}>12</option>
                <option value="24" {{ $preferences->paginacion === 24 ? 'selected' : '' }}>24</option>
                <option value="48" {{ $preferences->paginacion === 48 ? 'selected' : '' }}>48</option>
            </select>

            <button type="submit">Guardar</button>
        </form>
    </div>
@endsection