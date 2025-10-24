@extends('layouts.app')

@section('titulo', 'Panel Principal - Laboratorio DIALAB')

@section('contenido')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Tarjeta de Bienvenida -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-800">
                    ¡Bienvenido, {{ Auth::user()->nombre_completo }}!
                </h1>
                <p class="text-gray-600 mt-2">
                    Rol: <span class="font-medium capitalize">{{ Auth::user()->rol }}</span> | 
                    Fecha: <span class="font-medium">{{ now()->format('d/m/Y') }}</span>
                </p>
            </div>
        </div>

        <!-- Estadísticas del Sistema -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-gray-500">Total Pacientes</h3>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-file-medical text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-gray-500">Órdenes Hoy</h3>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-vial text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-gray-500">Muestras Pendientes</h3>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-lg">
                        <i class="fas fa-clock text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-gray-500">Resultados Pendientes</h3>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Acciones Rápidas</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('pacientes.index') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition duration-300 transform hover:scale-105">
                        <i class="fas fa-user-plus text-2xl mb-2"></i>
                        <div class="font-semibold">Nuevo Paciente</div>
                        <div class="text-sm opacity-90">Registrar paciente</div>
                    </a>

                    <a href="{{ route('ordenes.index') }}" 
                       class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center transition duration-300 transform hover:scale-105">
                        <i class="fas fa-file-medical-alt text-2xl mb-2"></i>
                        <div class="font-semibold">Nueva Orden</div>
                        <div class="text-sm opacity-90">Crear orden de análisis</div>
                    </a>

                    <a href="{{ route('muestras.index') }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white p-4 rounded-lg text-center transition duration-300 transform hover:scale-105">
                        <i class="fas fa-vial text-2xl mb-2"></i>
                        <div class="font-semibold">Gestionar Muestras</div>
                        <div class="text-sm opacity-90">Seguimiento de muestras</div>
                    </a>

                    <a href="{{ route('resultados.index') }}" 
                       class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg text-center transition duration-300 transform hover:scale-105">
                        <i class="fas fa-file-pdf text-2xl mb-2"></i>
                        <div class="font-semibold">Ver Resultados</div>
                        <div class="text-sm opacity-90">Consultar y validar</div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>Información del Sistema
                </h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Versión del Sistema:</span>
                        <span class="font-medium">v1.0.0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Laboratorio:</span>
                        <span class="font-medium">DIALAB</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ubicación:</span>
                        <span class="font-medium">La Paz - Bolivia</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Última Actualización:</span>
                        <span class="font-medium">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-bell text-yellow-500 mr-2"></i>Recordatorios
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                        <span>No hay pacientes registrados en el sistema</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span>Complete su perfil de usuario</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection