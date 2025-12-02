<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Str;

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ], [
            'email.unique' => 'El email ya está en uso',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres',
        ]);

        $rolCliente = Rol::where('nombre', 'Cliente')->first();

        $user = User::create([
            'rol_id' => $rolCliente->id,
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Inicia sesión automáticamente
        session([
            'usuario_id' => $user->id,
            'email' => $user->email,
            'sesion_id' => Str::random(40),
        ]);

        return redirect()->route('home')->with('success', '¡Registro exitoso! Bienvenido');
    }
}
