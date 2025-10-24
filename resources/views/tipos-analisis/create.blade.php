@extends('layouts.app')

@section('titulo', 'Nuevo Tipo de Análisis - Laboratorio DIALAB')

@section('contenido')
<div class="py-6">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-vial text-blue-600 mr-3"></i>
                    Nuevo Tipo de Análisis
                </h1>
            </div>

            <div class="p-6">
                <form action="{{ route('tipos-analisis.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre del Análisis *
                            </label>
                            <input type="text" name="nombre" id="nombre" 
                                   value="{{ old('nombre') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ej: Hemograma Completo"
                                   required>
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                                Descripción
                            </label>
                            <textarea name="descripcion" id="descripcion" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Descripción detallada del análisis...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">
                                    Precio (Bs.) *
                                </label>
                                <input type="number" name="precio" id="precio" 
                                       value="{{ old('precio') }}" step="0.01" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('precio')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tiempo_entrega_horas" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tiempo de Entrega (horas) *
                                </label>
                                <input type="number" name="tiempo_entrega_horas" id="tiempo_entrega_horas" 
                                       value="{{ old('tiempo_entrega_horas') }}" min="1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('tiempo_entrega_horas')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">
                                Categoría *
                            </label>
                            <select name="categoria" id="categoria" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Seleccione una categoría...</option>
                                @foreach($categorias as $categoria)
                                <option value="{{ $categoria }}" {{ old('categoria') == $categoria ? 'selected' : '' }}>
                                    {{ $categoria }}
                                </option>
                                @endforeach
                            </select>
                            @error('categoria')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 mt-6">
                        <a href="{{ route('tipos-analisis.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-300">
                            <i class="fas fa-arrow-left mr-2"></i> Cancelar
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300 flex items-center">
                            <i class="fas fa-save mr-2"></i> Guardar Análisis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection