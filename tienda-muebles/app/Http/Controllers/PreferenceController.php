<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function index() {
        $preferencias = $this->ObtenerCookie();

        return view('preferences.index', compact('preferencias'));
    }

    public function UpdateCookie(Request $request) {
        if (!Auth::check()) {
            return redirect()->route('preferences')->with('error', 'Debes iniciar sesión para guardar preferencias');
        }

        $validar = $request->validate([
            'paginacion' => 'required|integer|in:6,12,24,48',
            'tema' => 'required|string|in:light,dark',
            'moneda' => 'required|string|in:€,$,£',
        ]);

        $usuario = Auth::user();
        $usuario->tema = $validar['tema'];
        $usuario->moneda = $validar['moneda'];
        $usuario->paginacion = $validar['paginacion'];
        $usuario->save();

        return redirect()->route('preferences')->with('success', "Preferencias actualizadas");
    }

    public function GuardarCookie(Request $solicitud) {
        $validar = $solicitud->validate([
            'paginacion' => 'required|integer|in:6,12,24,48',
            'tema' => 'required|string|in:light,dark',
            'moneda' => 'required|string|in:€,$,£',
        ]);

        $duracionCookie = 43200;
        $cookietema = cookie('tema', $validar['tema'], $duracionCookie);
        $gcookiemoneda = cookie('moneda', $validar['moneda'], $duracionCookie);
        $cookiepaginacion = cookie('paginacion', $validar['paginacion'], $duracionCookie);

        return redirect()->route('preferences')->with('success', "Preferencias guardada")->withCookies([$cookietema, $gcookiemoneda, $cookiepaginacion]);
    }

    private function ObtenerCookie() {
        if (Auth::check()) {
            $usuario = Auth::user();
            return (object) [
                'tema' => $usuario->tema ?? 'light',
                'moneda' => $usuario->moneda ?? '€',
                'paginacion' => $usuario->paginacion ?? 12,
            ];
        } else {
            return (object) [
                'tema' => request()->cookie('tema', 'light'),
                'moneda' => request()->cookie('moneda', '€'),
                'paginacion' => (int) request()->cookie('paginacion', 12),
            ];
        }
    }
}
