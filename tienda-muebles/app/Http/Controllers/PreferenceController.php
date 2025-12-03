<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function index()
    {
        $preferencias = $this->getPreferences();

        return view('preferences.index', compact('preferencias'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'paginacion' => 'required|integer|in:6,12,24,48',
            'tema' => 'required|string|in:light,dark',
            'moneda' => 'required|string|in:€,$,£',
        ]);

        if (Auth::check()) {
            $user = Auth::user();
            $user->tema = $validated['tema'];
            $user->moneda = $validated['moneda'];
            $user->paginacion = $validated['paginacion'];
            $user->save();

            return redirect()->route('preferences')->with('success', "Preferencias actualizadas");
        } else {
            $cookieDuration = 43200; // 30 days (in minutes)
            $cookieTheme = cookie('tema', $validated['tema'], $cookieDuration);
            $cookieCurrency = cookie('moneda', $validated['moneda'], $cookieDuration);
            $cookiePagination = cookie('paginacion', $validated['paginacion'], $cookieDuration);

            return redirect()->route('preferences')
                ->with('success', "Preferencias guardadas")
                ->withCookies([$cookieTheme, $cookieCurrency, $cookiePagination]);
        }
    }

    private function getPreferences()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return (object) [
                'tema' => $user->tema ?? 'light',
                'moneda' => $user->moneda ?? '€',
                'paginacion' => $user->paginacion ?? 12,
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
