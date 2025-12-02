<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Arial", sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-top: 40px;
            background-color: #976f47;
            color: #fff;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.4rem;
        }

        form {
            background-color: #4b3828;
            padding: 30px 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 20px #33261ba8;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px;
            border: none;
            margin-bottom: 18px;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            background-color: #7c542d;
            border: none;
            border-radius: 6px;
            color: #fff;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background-color: #7e4c1a;
        }
        div {
            background: rgba(255, 0, 0, 0.2);
            border-left: 4px solid #ff4d4d;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            width: 100%;
            max-width: 450px;
        }

        li {
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <h1>Register</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        <br>
        <button type="submit">Register</button>
    </form>
    <form action="{{ route('login') }}" method="GET">
        @csrf
        <button type="submit">Login</button>
    </form>
</body>

</html>