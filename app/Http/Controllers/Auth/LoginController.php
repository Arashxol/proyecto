<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function mostrarFormularioLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'contrasena' => 'required',
        ]);

        $credenciales = $request->only('email', 'contrasena');
        $usuario = Usuario::where('email', $credenciales['email'])->first();

        if ($usuario && Hash::check($credenciales['contrasena'], $usuario->contrasena)) {
            if (!$usuario->activo) {
                return back()->withErrors([
                    'email' => 'Su cuenta está desactivada. Contacte al administrador.',
                ]);
            }

            Auth::login($usuario);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}