@extends('layouts.app')

@section('titulo', 'Gestión de Muestras - Laboratorio DIALAB')

@section('contenido')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Muestras</h1>
            <div class="flex space-x-2">
                <a href="{{ route('muestras.pendientes') }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-clock mr-2"></i> Muestras Pendientes
                </a>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            @php
                $estadosMuestras = [
                    'Recolectada' => ['color' => 'gray', 'icon' => 'vial'],
                    'En Transito' => ['color' => 'blue', 'icon' => 'truck'],
                    'En Analisis' => ['color' => 'yellow', 'icon' => 'microscope'],
                    'Analizada' => ['color' => 'green', 'icon' => 'check'],
                    'Resultado Listo' => ['color' => 'purple', 'icon' => 'file-medical']
                ];
            @endphp
            @foreach($estadosMuestras as $estado => $info)
            <div class="bg-white p-4 rounded-lg shadow border-l-4 border-{{ $info['color'] }}-500">
                <div class="flex items-center">
                    <i class="fas fa-{{ $info['icon'] }} text-{{ $info['color'] }}-600 text-xl mr-3"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">{{ $estado }}</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $muestras->where('estado', $estado)->count() }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Tabla de Muestras -->
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-800">Lista de Muestras</h2>
            </div>

            @if($muestras->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Muestra
                            </th>
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
                                Fecha Recolección
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($muestras as $muestra)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-blue-600">{{ $muestra->codigo_muestra }}</div>
                                <div class="text-sm text-gray-500">{{ $muestra->tipo_muestra }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $muestra->orden->paciente->nombre_completo }}</div>
                                <div class="text-sm text-gray-500">CI: {{ $muestra->orden->paciente->ci }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $muestra->tipoAnalisis->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $muestra->tipoAnalisis->categoria }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $estadoColors = [
                                        'Recolectada' => 'bg-gray-100 text-gray-800',
                                        'En Transito' => 'bg-blue-100 text-blue-800',
                                        'En Analisis' => 'bg-yellow-100 text-yellow-800',
                                        'Analizada' => 'bg-green-100 text-green-800',
                                        'Resultado Listo' => 'bg-purple-100 text-purple-800',
                                        'Archivada' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estadoColors[$muestra->estado] }}">
                                    <i class="fas fa-{{ $estadosMuestras[$muestra->estado]['icon'] }} mr-1"></i>
                                    {{ $muestra->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $muestra->fecha_recoleccion->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('muestras.show', $muestra) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('muestras.edit', $muestra) }}" 
                                       class="text-green-600 hover:text-green-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$muestra->resultado)
                                    <form action="{{ route('muestras.destroy', $muestra) }}" method="POST" 
                                          class="inline" onsubmit="return confirm('¿Está seguro de eliminar esta muestra?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @if($muestra->estado == 'Analizada' && !$muestra->resultado)
                                    <a href="{{ route('resultados.create', $muestra) }}" 
                                       class="text-purple-600 hover:text-purple-900" title="Registrar Resultado">
                                        <i class="fas fa-file-medical-alt"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $muestras->links() }}
            </div>
            @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-vial text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay muestras registradas</h3>
                <p class="text-gray-500 mb-4">Las muestras se crean automáticamente al generar órdenes de análisis.</p>
                <a href="{{ route('ordenes-analisis.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                    <i class="fas fa-file-medical mr-2"></i> Crear Orden
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection