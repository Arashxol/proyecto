@extends('layouts.app')

@section('titulo', 'Detalles del Paciente - Laboratorio DIALAB')

@section('contenido')
<div class="py-6">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <a href="{{ route('pacientes.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Detalles del Paciente</h1>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('pacientes.edit', $paciente) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
                <a href="{{ route('ordenes-analisis.create') }}?paciente_id={{ $paciente->id }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-file-medical mr-2"></i> Nueva Orden
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información del Paciente -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Tarjeta de Información Personal -->
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-blue-600 text-white">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-user-circle mr-2"></i>
                            Información Personal
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Nombre Completo</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $paciente->nombre_completo }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">C.I.</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $paciente->ci }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Edad</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $paciente->edad }} años</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Sexo</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $paciente->sexo }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-600">Dirección</label>
                                <p class="mt-1 text-gray-900">{{ $paciente->direccion }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-green-600 text-white">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-address-book mr-2"></i>
                            Información de Contacto
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Teléfono</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $paciente->telefono }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">
                                    {{ $paciente->email ?? 'No registrado' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Fecha de Registro</label>
                                <p class="mt-1 text-gray-900">{{ $paciente->fecha_registro->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Estado</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Activo
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                @if($paciente->observaciones)
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-yellow-600 text-white">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-sticky-note mr-2"></i>
                            Observaciones
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700">{{ $paciente->observaciones }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar - Estadísticas y Acciones -->
            <div class="space-y-6">
                <!-- Estadísticas -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Estadísticas</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Órdenes:</span>
                            <span class="font-semibold text-blue-600">{{ $ordenes->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Órdenes Pendientes:</span>
                            <span class="font-semibold text-yellow-600">
                                {{ $ordenes->where('estado', 'Pendiente')->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Órdenes Completadas:</span>
                            <span class="font-semibold text-green-600">
                                {{ $ordenes->where('estado', 'Completada')->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Acciones Rápidas</h3>
                    <div class="space-y-2">
                        <a href="{{ route('ordenes-analisis.create') }}?paciente_id={{ $paciente->id }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg flex items-center justify-center transition duration-300">
                            <i class="fas fa-file-medical mr-2"></i> Nueva Orden
                        </a>
                        <a href="{{ route('pacientes.edit', $paciente) }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg flex items-center justify-center transition duration-300">
                            <i class="fas fa-edit mr-2"></i> Editar Paciente
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de Órdenes -->
        <div class="mt-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-800 text-white">
                    <h2 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-history mr-2"></i>
                        Historial de Órdenes de Análisis
                    </h2>
                </div>
                
                @if($ordenes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Código Orden
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha Solicitud
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                    {{ $orden->codigo_orden }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Bs. {{ number_format($orden->total, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('ordenes-analisis.show', $orden) }}" 
                                       class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-file-medical text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay órdenes registradas</h3>
                    <p class="text-gray-500 mb-4">Este paciente no tiene órdenes de análisis.</p>
                    <a href="{{ route('ordenes-analisis.create') }}?paciente_id={{ $paciente->id }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-file-medical mr-2"></i> Crear Primera Orden
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection