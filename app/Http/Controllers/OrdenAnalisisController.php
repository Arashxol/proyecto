<?php

namespace App\Http\Controllers;

use App\Models\OrdenAnalisis;
use App\Models\Paciente;
use App\Models\TipoAnalisis;
use App\Models\Usuario;
use Illuminate\Http\Request;

class OrdenAnalisisController extends Controller
{
    public function index()
    {
        $ordenes = OrdenAnalisis::with(['paciente', 'medico'])->latest()->paginate(10);
        return view('ordenes-analisis.index', compact('ordenes'));
    }

    public function create()
    {
        $pacientes = Paciente::activos()->get();
        $tiposAnalisis = TipoAnalisis::activos()->get();
        $medicos = Usuario::where('rol', 'bioquimico')->orWhere('rol', 'administrador')->get();
        
        return view('ordenes-analisis.create', compact('pacientes', 'tiposAnalisis', 'medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_solicitante' => 'required|exists:usuarios,id',
            'diagnostico_presuntivo' => 'nullable|string',
            'tipos_analisis' => 'required|array|min:1',
            'tipos_analisis.*' => 'exists:tipos_analisis,id',
            'observaciones' => 'nullable|string',
        ]);

        // Calcular total
        $total = TipoAnalisis::whereIn('id', $request->tipos_analisis)->sum('precio');

        // Crear orden
        $orden = OrdenAnalisis::create([
            'codigo_orden' => OrdenAnalisis::generarCodigoOrden(),
            'paciente_id' => $request->paciente_id,
            'medico_solicitante' => $request->medico_solicitante,
            'diagnostico_presuntivo' => $request->diagnostico_presuntivo,
            'fecha_solicitud' => now(),
            'fecha_entrega_estimada' => now()->addHours(24), // 24 horas por defecto
            'total' => $total,
            'observaciones' => $request->observaciones,
        ]);

        // Adjuntar tipos de análisis
        $orden->tiposAnalisis()->attach($request->tipos_analisis);

        // Crear muestras para cada tipo de análisis
        foreach ($request->tipos_analisis as $tipoAnalisisId) {
            $orden->muestras()->create([
                'codigo_muestra' => \App\Models\Muestra::generarCodigoMuestra(),
                'tipo_analisis_id' => $tipoAnalisisId,
                'tipo_muestra' => 'Sangre', // Por defecto, se puede cambiar después
                'fecha_recoleccion' => now(),
            ]);
        }

        return redirect()->route('ordenes-analisis.show', $orden)
            ->with('exito', 'Orden de análisis creada exitosamente. Se generaron ' . count($request->tipos_analisis) . ' muestras.');
    }

    public function show(OrdenAnalisis $ordenesAnalisis)
    {
        $orden = $ordenesAnalisis->load(['paciente', 'medico', 'tiposAnalisis', 'muestras.tipoAnalisis', 'muestras.resultado']);
        return view('ordenes-analisis.show', compact('orden'));
    }

    public function edit(OrdenAnalisis $ordenesAnalisis)
    {
        $orden = $ordenesAnalisis->load('tiposAnalisis');
        $pacientes = Paciente::activos()->get();
        $tiposAnalisis = TipoAnalisis::activos()->get();
        $medicos = Usuario::where('rol', 'bioquimico')->orWhere('rol', 'administrador')->get();
        
        return view('ordenes-analisis.edit', compact('orden', 'pacientes', 'tiposAnalisis', 'medicos'));
    }

    public function update(Request $request, OrdenAnalisis $ordenesAnalisis)
    {
        $request->validate([
            'medico_solicitante' => 'required|exists:usuarios,id',
            'diagnostico_presuntivo' => 'nullable|string',
            'estado' => 'required|in:Pendiente,En Proceso,Completada,Cancelada',
            'observaciones' => 'nullable|string',
        ]);

        $ordenesAnalisis->update($request->only([
            'medico_solicitante', 
            'diagnostico_presuntivo', 
            'estado', 
            'observaciones'
        ]));

        return redirect()->route('ordenes-analisis.show', $ordenesAnalisis)
            ->with('exito', 'Orden de análisis actualizada exitosamente.');
    }

    public function destroy(OrdenAnalisis $ordenesAnalisis)
    {
        // Solo cancelar, no eliminar
        $ordenesAnalisis->update(['estado' => 'Cancelada']);
        
        return redirect()->route('ordenes-analisis.index')
            ->with('exito', 'Orden de análisis cancelada exitosamente.');
    }

    public function cambiarEstado(Request $request, OrdenAnalisis $orden)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,En Proceso,Completada,Cancelada'
        ]);

        $orden->update(['estado' => $request->estado]);

        return back()->with('exito', 'Estado de la orden actualizado exitosamente.');
    }
}