<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tienda Muebles')</title>
</head>

<body>
    <header>
        <div>
            <a>
                <h2>Tienda de Muebles</h2>
            </a>
            <nav>
                <ul>
                    <li><a>Iniciar Sesión</a></li>
                    <li><a>Registrarse</a></li>
                    <li><a>Productos</a></li>
                    <li><a href="{{ route('carrito.index') }}">Carrito</a></li>
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