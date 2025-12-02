@extends('layout')

@section('content')

    <div class="container">
        <h2>Preferencias</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="preferencesForm"
            action="{{ auth()->check() ? route('preferences.update') : route('preferences.cookie') }}" method="POST">
            @csrf
            @if(auth()->check())
                @method('PUT')
            @endif

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

    @if(!auth()->check())
        <script>
            // Para usuarios no autenticados, usar AJAX para guardar en cookies
            document.getElementById('preferencesForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const data = {
                    tema: formData.get('tema'),
                    moneda: formData.get('moneda'),
                    paginacion: formData.get('paginacion')
                };

                fetch('{{ route('preferences.cookie') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Preferencias guardadas correctamente');
                            location.reload(); // Recargar para aplicar las preferencias
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al guardar las preferencias');
                    });
            });
        </script>
    @endif

@endsection