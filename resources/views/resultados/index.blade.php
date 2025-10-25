@extends('layouts.app')

@section('titulo', 'Resultados de Análisis - Laboratorio DIALAB')

@section('contenido')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Resultados de Análisis</h1>
            <div class="flex space-x-2">
                <a href="{{ route('resultados.pendientes') }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-clock mr-2"></i> Pendientes de Validación
                </a>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                <div class="flex items-center">
                    <i class="fas fa-file-medical text-blue-600 text-xl mr-3"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Total Resultados</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $resultados->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <i class="fas fa-clock text-yellow-600 text-xl mr-3"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Pendientes</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $resultados->where('estado', 'Pendiente')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Validados</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $resultados->where('estado', 'Validado')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Resultados -->
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-800">Lista de Resultados</h2>
            </div>

            @if($resultados->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Paciente
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Análisis
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha Registro
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Validado Por
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($resultados as $resultado)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $resultado->muestra->orden->paciente->nombre_completo }}</div>
                                <div class="text-sm text-gray-500">CI: {{ $resultado->muestra->orden->paciente->ci }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $resultado->muestra->tipoAnalisis->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $resultado->muestra->codigo_muestra }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $estadoColors = [
                                        'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                        'Validado' => 'bg-green-100 text-green-800',
                                        'Rechazado' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estadoColors[$resultado->estado] }}">
                                    @if($resultado->estado == 'Pendiente')
                                    <i class="fas fa-clock mr-1"></i>
                                    @elseif($resultado->estado == 'Validado')
                                    <i class="fas fa-check-circle mr-1"></i>
                                    @else
                                    <i class="fas fa-times-circle mr-1"></i>
                                    @endif
                                    {{ $resultado->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $resultado->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $resultado->bioquimico->nombre_completo ?? 'No validado' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('resultados.show', $resultado) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($resultado->estado == 'Pendiente')
                                    <a href="{{ route('resultados.edit', $resultado) }}" 
                                       class="text-green-600 hover:text-green-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('resultados.reporte', $resultado) }}" 
                                       class="text-purple-600 hover:text-purple-900" title="Generar Reporte">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $resultados->links() }}
            </div>
            @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-file-medical text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay resultados registrados</h3>
                <p class="text-gray-500 mb-4">Los resultados se registran después de analizar las muestras.</p>
                <a href="{{ route('muestras.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                    <i class="fas fa-vial mr-2"></i> Ver Muestras
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection