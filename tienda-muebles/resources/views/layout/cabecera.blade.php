<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Muebles</title>
</head>

<body>
    <header>    
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('home') }}">Productos</a></li>
                <li><a href="{{ route('register') }}">Registrar</a></li>
                @auth
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit"
                                style="background: none; border: none; padding: 0; color: inherit; text-decoration: underline; cursor: pointer;">
                                Logout
                            </button>
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