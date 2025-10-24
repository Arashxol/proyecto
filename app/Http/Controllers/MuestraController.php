<?php

namespace App\Http\Controllers;

use App\Models\Muestra;
use App\Models\Usuario;
use Illuminate\Http\Request;

class MuestraController extends Controller
{
    public function index()
    {
        $muestras = Muestra::with(['orden.paciente', 'tipoAnalisis', 'tecnico'])
            ->latest()
            ->paginate(15);
        
        return view('muestras.index', compact('muestras'));
    }

    public function show(Muestra $muestra)
    {
        $muestra->load(['orden.paciente', 'tipoAnalisis', 'tecnico', 'resultado.bioquimico']);
        return view('muestras.show', compact('muestra'));
    }

    public function edit(Muestra $muestra)
    {
        $tecnicos = Usuario::where('rol', 'bioquimico')->orWhere('rol', 'recepcionista')->get();
        $tiposMuestra = ['Sangre', 'Orina', 'Heces', 'Saliva', 'Tejido', 'Otro'];
        $estados = ['Recolectada', 'En Transito', 'En Analisis', 'Analizada', 'Resultado Listo', 'Archivada'];
        
        return view('muestras.edit', compact('muestra', 'tecnicos', 'tiposMuestra', 'estados'));
    }

    public function update(Request $request, Muestra $muestra)
    {
        $request->validate([
            'tipo_muestra' => 'required|in:Sangre,Orina,Heces,Saliva,Tejido,Otro',
            'estado' => 'required|in:Recolectada,En Transito,En Analisis,Analizada,Resultado Listo,Archivada',
            'tecnico_asignado' => 'nullable|exists:usuarios,id',
            'fecha_analisis' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $data = $request->only([
            'tipo_muestra', 'estado', 'tecnico_asignado', 'observaciones'
        ]);

        // Si el estado cambia a "En Analisis", registrar fecha de análisis
        if ($request->estado == 'En Analisis' && !$muestra->fecha_analisis) {
            $data['fecha_analisis'] = now();
        }

        $muestra->update($data);

        return redirect()->route('muestras.show', $muestra)
            ->with('exito', 'Muestra actualizada exitosamente.');
    }

    public function destroy(Muestra $muestra)
    {
        // Verificar que no tenga resultados asociados
        if ($muestra->resultado) {
            return redirect()->route('muestras.show', $muestra)
                ->with('error', 'No se puede eliminar la muestra porque tiene resultados asociados.');
        }

        $muestra->delete();

        return redirect()->route('muestras.index')
            ->with('exito', 'Muestra eliminada exitosamente.');
    }

    public function pendientes()
    {
        $muestras = Muestra::pendientesAnalisis()
            ->with(['orden.paciente', 'tipoAnalisis'])
            ->latest()
            ->paginate(15);
        
        return view('muestras.pendientes', compact('muestras'));
    }

    public function asignarTecnico(Request $request, Muestra $muestra)
    {
        $request->validate([
            'tecnico_asignado' => 'required|exists:usuarios,id'
        ]);

        $muestra->update([
            'tecnico_asignado' => $request->tecnico_asignado,
            'estado' => 'En Analisis',
            'fecha_analisis' => now(),
        ]);

        return back()->with('exito', 'Técnico asignado exitosamente.');
    }
}