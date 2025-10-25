<?php

namespace App\Http\Controllers;

use App\Models\Resultado;
use App\Models\Muestra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultadoController extends Controller
{
    // Eliminar el constructor para evitar problemas con el middleware
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $resultados = Resultado::with(['muestra.orden.paciente', 'muestra.tipoAnalisis', 'bioquimico'])
            ->latest()
            ->paginate(15);
        
        return view('resultados.index', compact('resultados'));
    }

    public function create(Muestra $muestra)
    {
        if ($muestra->resultado) {
            return redirect()->route('muestras.show', $muestra)
                ->with('error', 'Esta muestra ya tiene un resultado registrado.');
        }

        if ($muestra->estado !== 'Analizada') {
            return redirect()->route('muestras.show', $muestra)
                ->with('error', 'La muestra debe estar en estado "Analizada" para registrar resultados.');
        }

        $muestra->load(['orden.paciente', 'tipoAnalisis']);
        return view('resultados.create', compact('muestra'));
    }

    public function store(Request $request, Muestra $muestra)
    {
        if ($muestra->resultado) {
            return redirect()->route('muestras.show', $muestra)
                ->with('error', 'Esta muestra ya tiene un resultado registrado.');
        }

        $request->validate([
            'resultado' => 'required|string|min:3',
            'valores_referencia' => 'nullable|string',
            'interpretacion' => 'nullable|string',
        ]);

        $resultado = Resultado::create([
            'muestra_id' => $muestra->id,
            'resultado' => $request->resultado,
            'valores_referencia' => $request->valores_referencia,
            'interpretacion' => $request->interpretacion,
            'estado' => 'Pendiente',
        ]);

        $muestra->update(['estado' => 'Resultado Listo']);

        return redirect()->route('resultados.show', $resultado)
            ->with('exito', 'Resultado registrado exitosamente. Pendiente de validación.');
    }

    public function show(Resultado $resultado)
    {
        $resultado->load([
            'muestra.orden.paciente', 
            'muestra.tipoAnalisis', 
            'bioquimico',
            'muestra.orden.medico'
        ]);
        
        return view('resultados.show', compact('resultado'));
    }

    public function edit(Resultado $resultado)
    {
        if ($resultado->estado !== 'Pendiente') {
            return redirect()->route('resultados.show', $resultado)
                ->with('error', 'Solo se pueden editar resultados pendientes de validación.');
        }

        $resultado->load(['muestra.orden.paciente', 'muestra.tipoAnalisis']);
        return view('resultados.edit', compact('resultado'));
    }

    public function update(Request $request, Resultado $resultado)
    {
        if ($resultado->estado !== 'Pendiente') {
            return redirect()->route('resultados.show', $resultado)
                ->with('error', 'Solo se pueden editar resultados pendientes de validación.');
        }

        $request->validate([
            'resultado' => 'required|string|min:3',
            'valores_referencia' => 'nullable|string',
            'interpretacion' => 'nullable|string',
        ]);

        $resultado->update([
            'resultado' => $request->resultado,
            'valores_referencia' => $request->valores_referencia,
            'interpretacion' => $request->interpretacion,
        ]);

        return redirect()->route('resultados.show', $resultado)
            ->with('exito', 'Resultado actualizado exitosamente.');
    }

    public function destroy(Resultado $resultado)
    {
        if ($resultado->estado !== 'Pendiente') {
            return redirect()->route('resultados.show', $resultado)
                ->with('error', 'Solo se pueden eliminar resultados pendientes de validación.');
        }

        $muestra = $resultado->muestra;
        $muestra->update(['estado' => 'Analizada']);
        $resultado->delete();

        return redirect()->route('muestras.show', $muestra)
            ->with('exito', 'Resultado eliminado exitosamente.');
    }

    public function validarResultado(Request $request, Resultado $resultado)
    {
        $request->validate([
            'accion' => 'required|in:validar,rechazar',
            'observaciones_validacion' => 'nullable|string',
        ]);

        if ($request->accion === 'validar') {
            $resultado->update([
                'estado' => 'Validado',
                'bioquimico_validador' => Auth::id(),
                'fecha_validacion' => now(),
                'observaciones_validacion' => $request->observaciones_validacion,
            ]);
            $mensaje = 'Resultado validado exitosamente.';
        } else {
            $resultado->update([
                'estado' => 'Rechazado',
                'bioquimico_validador' => Auth::id(),
                'fecha_validacion' => now(),
                'observaciones_validacion' => $request->observaciones_validacion,
            ]);
            $mensaje = 'Resultado rechazado.';
        }

        return back()->with('exito', $mensaje);
    }

    public function pendientesValidacion()
    {
        $resultados = Resultado::where('estado', 'Pendiente')
            ->with(['muestra.orden.paciente', 'muestra.tipoAnalisis'])
            ->latest()
            ->paginate(15);
        
        return view('resultados.pendientes', compact('resultados'));
    }

    public function generarReporte(Resultado $resultado)
    {
        $resultado->load([
            'muestra.orden.paciente', 
            'muestra.tipoAnalisis', 
            'bioquimico',
            'muestra.orden.medico'
        ]);

        if ($resultado->estado !== 'Validado') {
            return redirect()->route('resultados.show', $resultado)
                ->with('error', 'Solo se pueden generar reportes de resultados validados.');
        }
        
        return view('resultados.reporte', compact('resultado'));
    }
}