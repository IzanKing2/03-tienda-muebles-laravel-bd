<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar datos
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Autenticar
        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            return redirect()->route('home')->with('success', 'Bienvenido, ' . Auth::user()->nombre);
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Hasta luego');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);

        // Obtener el rol de cliente
        $rolCliente = Rol::where('nombre', 'Cliente')->first();

        $user = User::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $rolCliente->id,
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Usuario registrado correctamente');
    }
}
