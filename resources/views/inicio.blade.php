@extends('layouts.app')

@section('titulo', 'Laboratorio Clínico DIALAB - Sistema de Gestión')

@section('contenido')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
    <div class="max-w-6xl mx-auto p-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="md:flex">
                <!-- Panel Izquierdo - Información -->
                <div class="md:flex-shrink-0 md:w-1/2 bg-gradient-to-br from-blue-600 to-blue-800 p-12 text-white">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 rounded-full mb-6">
                            <i class="fas fa-flask text-3xl"></i>
                        </div>
                        <h1 class="text-4xl font-bold mb-4">Laboratorio Clínico DIALAB</h1>
                        <p class="text-blue-100 text-lg mb-8">
                            Sistema Integral de Gestión de Laboratorio Clínico
                        </p>
                        
                        <div class="space-y-4 text-left">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-300 mr-3 text-lg"></i>
                                <span class="text-blue-100">Gestión de pacientes y órdenes</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-300 mr-3 text-lg"></i>
                                <span class="text-blue-100">Trazabilidad completa de muestras</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-300 mr-3 text-lg"></i>
                                <span class="text-blue-100">Resultados confiables y seguros</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-300 mr-3 text-lg"></i>
                                <span class="text-blue-100">Reportes administrativos</span>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-blue-500">
                            <p class="text-blue-200">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                La Paz - Bolivia
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Panel Derecho - Acceso -->
                <div class="p-12 md:w-1/2">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Bienvenido al Sistema</h2>
                        <p class="text-gray-600">Acceda a la plataforma de gestión</p>
                    </div>
                    
                    <div class="space-y-6">
                        <a href="{{ route('login') }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center text-lg">
                            <i class="fas fa-sign-in-alt mr-3"></i>
                            Iniciar Sesión
                        </a>
                        
                        <a href="{{ route('registro') }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center text-lg">
                            <i class="fas fa-user-plus mr-3"></i>
                            Crear Cuenta Nueva
                        </a>
                    </div>

                    <div class="mt-8 text-center">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-2">¿Necesita ayuda?</h4>
                            <p class="text-sm text-gray-600">
                                Contacte al administrador del sistema para asistencia técnica.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 text-center text-sm text-gray-500">
                        <p>Laboratorio Clínico DIALAB &copy; 2025</p>
                        <p class="mt-1">Sistema de Gestión v1.0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection