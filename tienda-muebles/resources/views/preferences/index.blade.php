@extends('layout')

@section('content')

    <div class="container">
        <h2>Preferencias</h2>
        <form action="{{ route('preferences') }}" method="POST">
            @csrf
            @method('PUT')
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

            </select>
            <button type="submit">Guardar</button>
        </form>
    </div>

@endsection