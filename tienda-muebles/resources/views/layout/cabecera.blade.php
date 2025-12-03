<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Muebles</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            text-decoration: none;
            color: #7c542d;
        }

        a:hover {
            color: #98612a;
        }

        header {
            background-color: #36281d;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px #33261ba8;
            flex-wrap: wrap;
        }

        header h2 {
            margin: 0;
            font-size: 1.8rem;
            color: #ecf0f1;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        nav ul li a,
        nav ul li button {
            display: block;
            padding: 8px 12px;
            color: white;
            background-color: transparent;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1rem;
        }

        nav ul li a:hover,
        nav ul li button:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        nav ul li button[type="submit"] {
            color: #e74c3c;
            padding: 0;
        }

        nav ul li button[type="submit"]:hover {
            color: #c0392b;
            background-color: transparent;
        }

        footer {
            background-color: #36281d;
            color: white;
            text-align: center;
            padding: 15px 20px;
            margin-top: auto;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }

            header h2 {
                margin-bottom: 10px;
            }

            nav ul {
                justify-content: center;
            }
        }
    </style>
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