@extends('layouts.app')

@section('titulo', 'Registrar Resultado - Laboratorio DIALAB')

@section('contenido')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-file-medical-alt text-blue-600 mr-3"></i>
                    Registrar Resultado de Análisis
                </h1>
            </div>

            <div class="p-6">
                <!-- Información de la Muestra -->
                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">Información de la Muestra</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Paciente:</span>
                            <p class="text-gray-900">{{ $muestra->orden->paciente->nombre_completo }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">C.I.:</span>
                            <p class="text-gray-900">{{ $muestra->orden->paciente->ci }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Análisis:</span>
                            <p class="text-gray-900">{{ $muestra->tipoAnalisis->nombre }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Código Muestra:</span>
                            <p class="text-gray-900 font-mono">{{ $muestra->codigo_muestra }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Edad/Sexo:</span>
                            <p class="text-gray-900">{{ $muestra->orden->paciente->edad }} años, {{ $muestra->orden->paciente->sexo }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Médico:</span>
                            <p class="text-gray-900">{{ $muestra->orden->medico->nombre_completo ?? 'No asignado' }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('resultados.store', $muestra) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Resultado -->
                        <div>
                            <label for="resultado" class="block text-sm font-medium text-gray-700 mb-2">
                                Resultado del Análisis *
                            </label>
                            <textarea name="resultado" id="resultado" rows="6"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Ingrese los resultados del análisis..."
                                      required>{{ old('resultado') }}</textarea>
                            @error('resultado')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Valores de Referencia -->
                        <div>
                            <label for="valores_referencia" class="block text-sm font-medium text-gray-700 mb-2">
                                Valores de Referencia
                            </label>
                            <textarea name="valores_referencia" id="valores_referencia" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Valores normales de referencia...">{{ old('valores_referencia') }}</textarea>
                            @error('valores_referencia')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Interpretación -->
                        <div>
                            <label for="interpretacion" class="block text-sm font-medium text-gray-700 mb-2">
                                Interpretación Clínica
                            </label>
                            <textarea name="interpretacion" id="interpretacion" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Interpretación de los resultados...">{{ old('interpretacion') }}</textarea>
                            @error('interpretacion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Información Adicional -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                                <span class="text-sm font-medium text-yellow-800">Información Importante</span>
                            </div>
                            <p class="text-sm text-yellow-700">
                                El resultado quedará en estado <strong>"Pendiente de Validación"</strong> y deberá ser validado por un bioquímico antes de ser entregado al paciente.
                            </p>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 mt-6">
                        <a href="{{ route('muestras.show', $muestra) }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-300">
                            <i class="fas fa-arrow-left mr-2"></i> Cancelar
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300 flex items-center">
                            <i class="fas fa-save mr-2"></i> Registrar Resultado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection