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

            // Migrar preferencias de cookies a base de datos si existen
            $this->migrarPreferenciasDeCookies($request);

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

        return redirect()->route('home')->with('success', 'Hasta luego');
    }

    /**
     * Migra las preferencias de las cookies a la base de datos del usuario autenticado
     */
    private function migrarPreferenciasDeCookies(Request $request)
    {
        $user = Auth::user();
        $updated = false;

        // Verificar y migrar cada preferencia si existe en cookies
        if ($request->hasCookie('tema')) {
            $user->tema = $request->cookie('tema');
            $updated = true;
        }

        if ($request->hasCookie('moneda')) {
            $user->moneda = $request->cookie('moneda');
            $updated = true;
        }

        if ($request->hasCookie('paginacion')) {
            $user->paginacion = $request->cookie('paginacion');
            $updated = true;
        }

        // Guardar cambios si hubo actualizaciones
        if ($updated) {
            $user->save();
        }
    }

    /**
     * Aplica las preferencias de las cookies al usuario recién creado
     */
    private function aplicarPreferenciasDeCookies(Request $request, User $user)
    {
        $updated = false;

        // Verificar y aplicar cada preferencia si existe en cookies
        if ($request->hasCookie('tema')) {
            $user->tema = $request->cookie('tema');
            $updated = true;
        }

        if ($request->hasCookie('moneda')) {
            $user->moneda = $request->cookie('moneda');
            $updated = true;
        }

        if ($request->hasCookie('paginacion')) {
            $user->paginacion = $request->cookie('paginacion');
            $updated = true;
        }

        // Guardar cambios si hubo actualizaciones
        if ($updated) {
            $user->save();
        }
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
        ], [
            'email.unique' => 'El email ya está en uso',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres',
        ]);

        $rolCliente = Rol::where('nombre', 'Cliente')->first();

        $user = User::create([
            'rol_id' => $rolCliente->id,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Aplicar preferencias de cookies si existen
        $this->aplicarPreferenciasDeCookies($request, $user);

        // Inicia sesión automáticamente
        Auth::login($user);

        return redirect()->route('home')->with('success', '¡Registro exitoso! Bienvenido');
    }
}
