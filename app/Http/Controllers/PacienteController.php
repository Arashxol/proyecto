<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::activos()->latest()->paginate(10);
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'ci' => 'required|string|unique:pacientes,ci',
            'edad' => 'required|integer|min:0|max:120',
            'sexo' => 'required|in:Masculino,Femenino',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'email' => 'nullable|email',
            'observaciones' => 'nullable|string',
        ]);

        Paciente::create([
            'nombre_completo' => $request->nombre_completo,
            'ci' => $request->ci,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'fecha_registro' => now(),
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('pacientes.index')
            ->with('exito', 'Paciente registrado exitosamente.');
    }

    public function show(Paciente $paciente)
    {
        $ordenes = $paciente->ordenes()->with('muestras', 'tiposAnalisis')->latest()->get();
        return view('pacientes.show', compact('paciente', 'ordenes'));
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'ci' => 'required|string|unique:pacientes,ci,' . $paciente->id,
            'edad' => 'required|integer|min:0|max:120',
            'sexo' => 'required|in:Masculino,Femenino',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'email' => 'nullable|email',
            'observaciones' => 'nullable|string',
        ]);

        $paciente->update($request->all());

        return redirect()->route('pacientes.index')
            ->with('exito', 'Paciente actualizado exitosamente.');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->update(['activo' => false]);
        
        return redirect()->route('pacientes.index')
            ->with('exito', 'Paciente desactivado exitosamente.');
    }
}