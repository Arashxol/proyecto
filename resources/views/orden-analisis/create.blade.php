@extends('layouts.app')

@section('titulo', 'Nueva Orden de Análisis - Laboratorio DIALAB')

@section('contenido')
<div class="py-6">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-file-medical text-blue-600 mr-3"></i>
                    Nueva Orden de Análisis
                </h1>
            </div>

            <div class="p-6">
                <form action="{{ route('ordenes-analisis.store') }}" method="POST" id="ordenForm">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Información Básica -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Selección de Paciente -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-user mr-2 text-blue-600"></i>
                                    Selección de Paciente
                                </h3>
                                
                                @if(request('paciente_id'))
                                    @php
                                        $pacienteSeleccionado = \App\Models\Paciente::find(request('paciente_id'));
                                    @endphp
                                    @if($pacienteSeleccionado)
                                    <div class="bg-blue-50 p-3 rounded-lg mb-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-semibold text-blue-800">{{ $pacienteSeleccionado->nombre_completo }}</p>
                                                <p class="text-sm text-blue-600">CI: {{ $pacienteSeleccionado->ci }} | Edad: {{ $pacienteSeleccionado->edad }} años</p>
                                            </div>
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                                Seleccionado
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="paciente_id" value="{{ $pacienteSeleccionado->id }}">
                                    @endif
                                @else
                                <div>
                                    <label for="paciente_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Buscar Paciente *
                                    </label>
                                    <select name="paciente_id" id="paciente_id" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            required>
                                        <option value="">Seleccione un paciente...</option>
                                        @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                            {{ $paciente->nombre_completo }} - CI: {{ $paciente->ci }} - {{ $paciente->edad }} años
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('paciente_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                @endif
                            </div>

                            <!-- Selección de Análisis -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-vial mr-2 text-green-600"></i>
                                    Selección de Análisis
                                </h3>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tipos de Análisis Disponibles *
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-60 overflow-y-auto p-2 border border-gray-200 rounded-lg">
                                        @foreach($tiposAnalisis->groupBy('categoria') as $categoria => $analisis)
                                        <div class="col-span-2">
                                            <h4 class="font-semibold text-gray-700 mb-2 text-sm">{{ $categoria }}</h4>
                                            <div class="space-y-2 mb-3">
                                                @foreach($analisis as $tipo)
                                                <label class="flex items-center space-x-3 p-2 hover:bg-white rounded cursor-pointer">
                                                    <input type="checkbox" name="tipos_analisis[]" 
                                                           value="{{ $tipo->id }}" 
                                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                           data-precio="{{ $tipo->precio }}"
                                                           onchange="calcularTotal()">
                                                    <span class="flex-1 text-sm">{{ $tipo->nombre }}</span>
                                                    <span class="text-sm font-medium text-green-600">
                                                        Bs. {{ number_format($tipo->precio, 2) }}
                                                    </span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @error('tipos_analisis')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Información Médica -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-stethoscope mr-2 text-purple-600"></i>
                                    Información Médica
                                </h3>

                                <div class="mb-4">
                                    <label for="medico_solicitante" class="block text-sm font-medium text-gray-700 mb-2">
                                        Médico Solicitante *
                                    </label>
                                    <select name="medico_solicitante" id="medico_solicitante" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            required>
                                        <option value="">Seleccione un médico...</option>
                                        @foreach($medicos as $medico)
                                        <option value="{{ $medico->id }}" {{ old('medico_solicitante') == $medico->id ? 'selected' : '' }}>
                                            {{ $medico->nombre_completo }} - {{ $medico->rol }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('medico_solicitante')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="diagnostico_presuntivo" class="block text-sm font-medium text-gray-700 mb-2">
                                        Diagnóstico Presuntivo
                                    </label>
                                    <textarea name="diagnostico_presuntivo" id="diagnostico_presuntivo" rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Diagnóstico presuntivo o motivo de la solicitud...">{{ old('diagnostico_presuntivo') }}</textarea>
                                    @error('diagnostico_presuntivo')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                                        Observaciones
                                    </label>
                                    <textarea name="observaciones" id="observaciones" rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Resumen y Total -->
                        <div class="space-y-6">
                            <div class="bg-blue-50 p-4 rounded-lg sticky top-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-receipt mr-2 text-blue-600"></i>
                                    Resumen de la Orden
                                </h3>

                                <div class="space-y-3 mb-4">
                                    <div id="analisisSeleccionados" class="text-sm text-gray-600">
                                        No hay análisis seleccionados
                                    </div>
                                </div>

                                <div class="border-t border-blue-200 pt-3">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-700">Subtotal:</span>
                                        <span id="subtotal" class="text-sm text-gray-600">Bs. 0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center text-lg font-bold">
                                        <span class="text-gray-800">Total:</span>
                                        <span id="total" class="text-blue-600">Bs. 0.00</span>
                                    </div>
                                </div>

                                <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                                    <p class="text-xs text-yellow-700">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Al guardar, se crearán automáticamente las muestras para cada análisis seleccionado.
                                    </p>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="space-y-3">
                                <a href="{{ route('ordenes-analisis.index') }}" 
                                   class="w-full bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                    <i class="fas fa-arrow-left mr-2"></i> Cancelar
                                </a>
                                <button type="submit" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Crear Orden
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function calcularTotal() {
    const checkboxes = document.querySelectorAll('input[name="tipos_analisis[]"]:checked');
    let subtotal = 0;
    let analisisList = '';

    checkboxes.forEach(checkbox => {
        const precio = parseFloat(checkbox.getAttribute('data-precio'));
        const nombre = checkbox.parentElement.querySelector('span:first-child').textContent.trim();
        subtotal += precio;
        analisisList += `<div class="flex justify-between text-xs">
            <span>${nombre}</span>
            <span>Bs. ${precio.toFixed(2)}</span>
        </div>`;
    });

    document.getElementById('subtotal').textContent = `Bs. ${subtotal.toFixed(2)}`;
    document.getElementById('total').textContent = `Bs. ${subtotal.toFixed(2)}`;
    
    if (analisisList) {
        document.getElementById('analisisSeleccionados').innerHTML = analisisList;
    } else {
        document.getElementById('analisisSeleccionados').innerHTML = 'No hay análisis seleccionados';
    }
}

// Calcular total inicialmente
calcularTotal();
</script>
@endsection