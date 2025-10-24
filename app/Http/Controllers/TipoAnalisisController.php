<?php

namespace App\Http\Controllers;

use App\Models\TipoAnalisis;
use Illuminate\Http\Request;

class TipoAnalisisController extends Controller
{
    public function index()
    {
        $tiposAnalisis = TipoAnalisis::activos()->latest()->paginate(10);
        return view('tipos-analisis.index', compact('tiposAnalisis'));
    }

    public function create()
    {
        $categorias = ['Hematología', 'Bioquímica', 'Orina', 'Heces', 'Inmunología', 'Microbiología', 'Serología'];
        return view('tipos-analisis.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipos_analisis,nombre',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
            'tiempo_entrega_horas' => 'required|integer|min:1',
        ]);

        TipoAnalisis::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'categoria' => $request->categoria,
            'tiempo_entrega_horas' => $request->tiempo_entrega_horas,
        ]);

        return redirect()->route('tipos-analisis.index')
            ->with('exito', 'Tipo de análisis creado exitosamente.');
    }

    public function show(TipoAnalisis $tiposAnalisis)
    {
        return view('tipos-analisis.show', compact('tiposAnalisis'));
    }

    public function edit(TipoAnalisis $tiposAnalisis)
    {
        $categorias = ['Hematología', 'Bioquímica', 'Orina', 'Heces', 'Inmunología', 'Microbiología', 'Serología'];
        return view('tipos-analisis.edit', compact('tiposAnalisis', 'categorias'));
    }

    public function update(Request $request, TipoAnalisis $tiposAnalisis)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipos_analisis,nombre,' . $tiposAnalisis->id,
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
            'tiempo_entrega_horas' => 'required|integer|min:1',
        ]);

        $tiposAnalisis->update($request->all());

        return redirect()->route('tipos-analisis.index')
            ->with('exito', 'Tipo de análisis actualizado exitosamente.');
    }

    public function destroy(TipoAnalisis $tiposAnalisis)
    {
        $tiposAnalisis->update(['activo' => false]);
        
        return redirect()->route('tipos-analisis.index')
            ->with('exito', 'Tipo de análisis desactivado exitosamente.');
    }
}