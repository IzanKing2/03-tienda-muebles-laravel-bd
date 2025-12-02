<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Muebles</title>
</head>

<body>
    <header>
        <h2>Tienda de Muebles</h2>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('productos.index') }}">Productos</a></li>
                <li><a href="{{ route('register') }}">Registrar</a></li>
                <li><a href="{{ route('preferences') }}">Preferencias</a></li>
                <li><a href="{{ route('carrito') }}">Carrito</a></li>
                @auth
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Cerrar sesión</button>
                        </form>
                    </li>

                @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                @endauth
            </ul>
        </nav>
    </header>
    @yield('content')
    <footer>
        <p>© {{ date('Y') }} Tienda de muebles. Todos los derechos reservados.</p>
    </footer>
</body>

</html>