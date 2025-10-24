@extends('layouts.app')

@section('titulo', 'Registro - Laboratorio DIALAB')

@section('contenido')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center">
                <i class="fas fa-flask text-white text-xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Crear Cuenta
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Regístrese en el sistema de gestión
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('registro') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="nombre_completo" class="sr-only">Nombre Completo</label>
                    <input id="nombre_completo" name="nombre_completo" type="text" autocomplete="name" required 
                           class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="Nombre completo" value="{{ old('nombre_completo') }}">
                    @error('nombre_completo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="sr-only">Correo Electrónico</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="Correo electrónico" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rol" class="block text-sm font-medium text-gray-700 mb-1">Rol en el Sistema</label>
                    <select id="rol" name="rol" required 
                            class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm">
                        <option value="">Seleccione un rol</option>
                        <option value="administrador" {{ old('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="recepcionista" {{ old('rol') == 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                        <option value="bioquimico" {{ old('rol') == 'bioquimico' ? 'selected' : '' }}>Bioquímico</option>
                    </select>
                    @error('rol')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contrasena" class="sr-only">Contraseña</label>
                    <input id="contrasena" name="contrasena" type="password" autocomplete="new-password" required 
                           class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="Contraseña (mínimo 8 caracteres)">
                    @error('contrasena')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contrasena_confirmation" class="sr-only">Confirmar Contraseña</label>
                    <input id="contrasena_confirmation" name="contrasena_confirmation" type="password" autocomplete="new-password" required 
                           class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="Confirmar contraseña">
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-blue-300"></i>
                    </span>
                    Crear Cuenta
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 text-sm">
                    ¿Ya tienes cuenta? Inicia sesión aquí
                </a>
            </div>
        </form>
    </div>
</div>
@endsection