@extends('layout.cabecera')
<style>
    body {
        background-color: #976f47;
    }
        
    .container {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px #33261ba8;
        font-family: Arial, sans-serif;
    }

    .container h2 {
        color: #333333;
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 2px solid #eeeeee;
        padding-bottom: 10px;
    }

    .container div:first-of-type { 
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
        font-weight: bold;
        text-align: center;
    }

    .container div:first-of-type[style*="success"] {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .container div:first-of-type[style*="error"] {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .container form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .container label {
        font-weight: bold;
        color: #555555;
        margin-bottom: 5px;
        display: block;
    }

    .container select {
        width: 100%;
        padding: 10px;
        border: 1px solid #cccccc;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: #f9f9f9;
        font-size: 16px;
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .container select:focus {
        border-color: #7c542d;
        outline: none;
        box-shadow: 0 0 3px #33261ba8;
    }

    .container button[type="submit"] {
        background-color: #5c4033;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
        margin-top: 10px;
        transition: background-color 0.3s ease;
    }

    .container button[type="submit"]:hover {
        background-color: #7b5b4e;
    }
</style>

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

        <form action="{{ route('preferences.update') }}" method="POST">
            @csrf
            @method('PUT')

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