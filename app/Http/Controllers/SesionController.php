<?php

namespace App\Http\Controllers;

use App\Http\Requests\IniciarSesionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SesionController extends Controller
{
    public function create(): View
    {
        return view('auth.iniciar-sesion');
    }

    public function store(IniciarSesionRequest $request): RedirectResponse
    {
        $request->autenticar();

        // Evita la fijación de sesión
        $request->session()->regenerate();

        return redirect()->intended(route('panel'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
