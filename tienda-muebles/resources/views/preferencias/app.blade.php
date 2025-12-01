<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tienda Muebles')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <header>
        <div>
            <a>
                <h2>Tienda de Muebles</h2>
            </a>
            <nav>
                <ul>
                    <li><a>Productos</a></li>
                    <li><a>Carrito</a></li>
                    <li><a>Preferencias</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <footer>
        <p>&copy;2025 Tienda de Muebles</p>
    </footer>
</body>
</html>