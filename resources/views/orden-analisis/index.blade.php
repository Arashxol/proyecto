@extends('layouts.app')

@section('titulo', 'Órdenes de Análisis - Laboratorio DIALAB')

@section('contenido')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Órdenes de Análisis</h1>
            <a href="{{ route('ordenes-analisis.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-file-medical mr-2"></i> Nueva Orden
            </a>
        </div>

        <!-- Filtros -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Todos los estados</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Completada">Completada</option>
                        <option value="Cancelada">Cancelada</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Desde</label>
                    <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Hasta</label>
                    <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="flex items-end">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg w-full">
                        <i class="fas fa-filter mr-2"></i> Filtrar
                    </button>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @php
                $estados = [
                    'Pendiente' => ['color' => 'yellow', 'icon' => 'clock'],
                    'En Proceso' => ['color' => 'blue', 'icon' => 'cog'],
                    'Completada' => ['color' => 'green', 'icon' => 'check-circle'],
                    'Cancelada' => ['color' => 'red', 'icon' => 'times-circle']
                ];
            @endphp
            @foreach($estados as $estado => $info)
            <div class="bg-white p-4 rounded-lg shadow border-l-4 border-{{ $info['color'] }}-500">
                <div class="flex items-center">
                    <i class="fas fa-{{ $info['icon'] }} text-{{ $info['color'] }}-600 text-xl mr-3"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">{{ $estado }}</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $ordenes->where('estado', $estado)->count() }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Tabla de Órdenes -->
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-800">Lista de Órdenes</h2>
            </div>

            @if($ordenes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Orden
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Paciente
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($ordenes as $orden)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-blue-600">{{ $orden->codigo_orden }}</div>
                                <div class="text-sm text-gray-500">{{ $orden->tiposAnalisis->count() }} análisis</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $orden->paciente->nombre_completo }}</div>
                                <div class="text-sm text-gray-500">CI: {{ $orden->paciente->ci }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $orden->fecha_solicitud->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $estadoColors = [
                                        'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                        'En Proceso' => 'bg-blue-100 text-blue-800',
                                        'Completada' => 'bg-green-100 text-green-800',
                                        'Cancelada' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estadoColors[$orden->estado] }}">
                                    {{ $orden->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Bs. {{ number_format($orden->total, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('ordenes-analisis.show', $orden) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('ordenes-analisis.edit', $orden) }}" 
                                       class="text-green-600 hover:text-green-900" title="Editar">
                                        <i class="fas fa-edit"></i>
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
                {{ $ordenes->links() }}
            </div>
            @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-file-medical text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay órdenes registradas</h3>
                <p class="text-gray-500 mb-4">Comience creando la primera orden de análisis.</p>
                <a href="{{ route('ordenes-analisis.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                    <i class="fas fa-file-medical mr-2"></i> Crear Primera Orden
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection