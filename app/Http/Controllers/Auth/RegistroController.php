<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function mostrarFormularioRegistro()
    {
        return view('auth.registro');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'contrasena' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:administrador,recepcionista,bioquimico',
        ]);

        $usuario = Usuario::create([
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'contrasena' => Hash::make($request->contrasena),
            'rol' => $request->rol,
        ]);

        Auth::login($usuario);

        return redirect('/dashboard')->with('exito', '¡Cuenta creada exitosamente!');
    }
}