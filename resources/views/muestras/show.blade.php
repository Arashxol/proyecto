@extends('layouts.app')

@section('titulo', 'Detalles de Muestra - Laboratorio DIALAB')

@section('contenido')
<div class="py-6">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <a href="{{ route('muestras.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Detalles de Muestra</h1>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('muestras.edit', $muestra) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
                @if($muestra->estado == 'Analizada' && !$muestra->resultado)
                <a href="{{ route('resultados.create', $muestra) }}" 
                   class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-file-medical-alt mr-2"></i> Registrar Resultado
                </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información de la Muestra -->
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-blue-600 text-white">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-vial mr-2"></i>
                            Información de la Muestra
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Código de Muestra</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $muestra->codigo_muestra }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Tipo de Muestra</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $muestra->tipo_muestra }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Estado</label>
                                <p class="mt-1">
                                    @php
                                        $estadoColors = [
                                            'Recolectada' => 'bg-gray-100 text-gray-800',
                                            'En Transito' => 'bg-blue-100 text-blue-800',
                                            'En Analisis' => 'bg-yellow-100 text-yellow-800',
                                            'Analizada' => 'bg-green-100 text-green-800',
                                            'Resultado Listo' => 'bg-purple-100 text-purple-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $estadoColors[$muestra->estado] }}">
                                        {{ $muestra->estado }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Fecha Recolección</label>
                                <p class="mt-1 text-gray-900">{{ $muestra->fecha_recoleccion->format('d/m/Y H:i') }}</p>
                            </div>
                            @if($muestra->fecha_analisis)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Fecha Análisis</label>
                                <p class="mt-1 text-gray-900">{{ $muestra->fecha_analisis->format('d/m/Y H:i') }}</p>
                            </div>
                            @endif
                            @if($muestra->tecnico_asignado)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Técnico Asignado</label>
                                <p class="mt-1 text-gray-900">{{ $muestra->tecnico->nombre_completo }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información del Análisis -->
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-green-600 text-white">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-microscope mr-2"></i>
                            Información del Análisis
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Tipo de Análisis</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $muestra->tipoAnalisis->nombre }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Categoría</label>
                                <p class="mt-1 text-gray-900">{{ $muestra->tipoAnalisis->categoria }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Precio</label>
                                <p class="mt-1 text-gray-900">Bs. {{ number_format($muestra->tipoAnalisis->precio, 2) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Tiempo Entrega</label>
                                <p class="mt-1 text-gray-900">{{ $muestra->tipoAnalisis->tiempo_entrega_horas }} horas</p>
                            </div>
                            @if($muestra->tipoAnalisis->descripcion)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-600">Descripción</label>
                                <p class="mt-1 text-gray-900">{{ $muestra->tipoAnalisis->descripcion }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información del Paciente -->
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-purple-600 text-white">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-user-injured mr-2"></i>
                            Información del Paciente
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Paciente</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $muestra->orden->paciente->nombre_completo }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">C.I.</label>
                                <p class="mt-1 text-gray-900">{{ $muestra->orden->paciente->ci }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Edad</label>
                                <p class="mt-1 text-gray-900">{{ $muestra->orden->paciente->edad }} años</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Sexo</label>
                                <p class="mt-1 text-gray-900">{{ $muestra->orden->paciente->sexo }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-600">Orden de Análisis</label>
                                <p class="mt-1">
                                    <a href="{{ route('ordenes-analisis.show', $muestra->orden) }}" 
                                       class="text-blue-600 hover:text-blue-800 font-semibold">
                                        {{ $muestra->orden->codigo_orden }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Estado y Acciones -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Estado y Acciones</h3>
                    
                    <!-- Timeline del Estado -->
                    <div class="space-y-4 mb-6">
                        @php
                            $estadosTimeline = [
                                'Recolectada' => ['icon' => 'vial', 'color' => 'gray'],
                                'En Transito' => ['icon' => 'truck', 'color' => 'blue'],
                                'En Analisis' => ['icon' => 'microscope', 'color' => 'yellow'],
                                'Analizada' => ['icon' => 'check', 'color' => 'green'],
                                'Resultado Listo' => ['icon' => 'file-medical', 'color' => 'purple']
                            ];
                            
                            $estadosArray = array_keys($estadosTimeline);
                            $estadoActualIndex = array_search($muestra->estado, $estadosArray);
                        @endphp

                        @foreach($estadosTimeline as $estado => $info)
                            @php
                                $currentIndex = array_search($estado, $estadosArray);
                                $isCompleted = $currentIndex <= $estadoActualIndex;
                                $isCurrent = $currentIndex == $estadoActualIndex;
                            @endphp
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center 
                                        {{ $isCompleted ? 'bg-' . $info['color'] . '-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                        <i class="fas fa-{{ $info['icon'] }} text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium {{ $isCompleted ? 'text-gray-900' : 'text-gray-500' }}">
                                        {{ $estado }}
                                    </p>
                                    @if($isCurrent)
                                    <p class="text-xs text-gray-500">Estado actual</p>
                                    @endif
                                </div>
                            </div>
                            @if(!$loop->last)
                            <div class="ml-4 border-l-2 border-gray-200 h-4"></div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="space-y-2">
                        @if($muestra->estado == 'Recolectada' || $muestra->estado == 'En Transito')
                        <form action="{{ route('muestras.asignar-tecnico', $muestra) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-lg flex items-center justify-center transition duration-300">
                                <i class="fas fa-user-cog mr-2"></i> Asignar a Análisis
                            </button>
                        </form>
                        @endif

                        @if($muestra->estado == 'Analizada' && !$muestra->resultado)
                        <a href="{{ route('resultados.create', $muestra) }}" 
                           class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg flex items-center justify-center transition duration-300">
                            <i class="fas fa-file-medical-alt mr-2"></i> Registrar Resultado
                        </a>
                        @endif

                        @if($muestra->resultado)
                        <a href="{{ route('resultados.show', $muestra->resultado) }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg flex items-center justify-center transition duration-300">
                            <i class="fas fa-file-pdf mr-2"></i> Ver Resultado
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Información de la Orden -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Información de la Orden</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Código Orden:</span>
                            <a href="{{ route('ordenes-analisis.show', $muestra->orden) }}" 
                               class="text-blue-600 font-medium">{{ $muestra->orden->codigo_orden }}</a>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fecha Solicitud:</span>
                            <span class="font-medium">{{ $muestra->orden->fecha_solicitud->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Estado Orden:</span>
                            <span class="font-medium">{{ $muestra->orden->estado }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Médico:</span>
                            <span class="font-medium">{{ $muestra->orden->medico->nombre_completo ?? 'No asignado' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Observaciones -->
        @if($muestra->observaciones)
        <div class="mt-6">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-yellow-600 text-white">
                    <h2 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-sticky-note mr-2"></i>
                        Observaciones
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 whitespace-pre-line">{{ $muestra->observaciones }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection