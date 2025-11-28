<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('home') }}">Productos</a></li>
                @if (Auth::check())
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                @endif
            </ul>
        </nav>
    </header>
    @yield('content')
    <footer>
        <p>© {{ date('Y') }} Tienda de muebles. Todos los derechos reservados.</p>
    </footer>
</body>

</html>