<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    // Eliminar el constructor
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $usuarios = Usuario::where('id', '!=', auth()->id())->latest()->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = ['administrador', 'recepcionista', 'bioquimico'];
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'contrasena' => 'required|string|min:8|confirmed',
            'rol' => ['required', Rule::in(['administrador', 'recepcionista', 'bioquimico'])],
        ]);

        Usuario::create([
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'contrasena' => Hash::make($request->contrasena),
            'rol' => $request->rol,
        ]);

        return redirect()->route('usuarios.index')
            ->with('exito', 'Usuario creado exitosamente.');
    }

    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        $roles = ['administrador', 'recepcionista', 'bioquimico'];
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('usuarios')->ignore($usuario->id),
            ],
            'rol' => ['required', Rule::in(['administrador', 'recepcionista', 'bioquimico'])],
            'activo' => 'required|boolean',
        ]);

        $data = [
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'rol' => $request->rol,
            'activo' => $request->activo,
        ];

        if ($request->filled('contrasena')) {
            $request->validate([
                'contrasena' => 'string|min:8|confirmed',
            ]);
            $data['contrasena'] = Hash::make($request->contrasena);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')
            ->with('exito', 'Usuario actualizado exitosamente.');
    }

    public function destroy(Usuario $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puede eliminar su propio usuario.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('exito', 'Usuario eliminado exitosamente.');
    }

    public function toggleActivo(Usuario $usuario)
    {
        $usuario->update(['activo' => !$usuario->activo]);

        $estado = $usuario->activo ? 'activado' : 'desactivado';
        return back()->with('exito', "Usuario {$estado} exitosamente.");
    }
}