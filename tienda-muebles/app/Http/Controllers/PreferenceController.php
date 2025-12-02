<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function index()
    {
        // Obtener preferencias según el estado de autenticación
        $preferences = $this->getPreferences();

        return view('preferences.index', compact('preferences'));
    }

    /**
     * Actualiza las preferencias del usuario autenticado en la base de datos
     */
    public function update(Request $request)
    {
        // Solo para usuarios autenticados
        if (!Auth::check()) {
            return redirect()->route('preferences')->with('error', 'Debes iniciar sesión para guardar preferencias');
        }

        // Validar los datos
        $validated = $request->validate([
            'paginacion' => 'required|integer|in:6,12,24,48',
            'tema' => 'required|string|in:light,dark',
            'moneda' => 'required|string|in:€,$,£',
        ]);

        // Actualizar preferencias del usuario
        $user = Auth::user();
        $user->tema = $validated['tema'];
        $user->moneda = $validated['moneda'];
        $user->paginacion = $validated['paginacion'];
        $user->save();

        return redirect()->route('preferences')->with('success', 'Preferencias actualizadas correctamente');
    }

    /**
     * Obtiene las preferencias del usuario (desde BD si está autenticado, desde cookies si no)
     */
    private function getPreferences()
    {
        if (Auth::check()) {
            // Usuario autenticado: obtener de la base de datos
            $user = Auth::user();
            return (object) [
                'tema' => $user->tema ?? 'light',
                'moneda' => $user->moneda ?? '€',
                'paginacion' => $user->paginacion ?? 12,
            ];
        } else {
            // Usuario invitado: obtener de cookies o valores por defecto
            return (object) [
                'tema' => request()->cookie('tema', 'light'),
                'moneda' => request()->cookie('moneda', '€'),
                'paginacion' => (int) request()->cookie('paginacion', 12),
            ];
        }
    }
}
