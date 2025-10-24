<nav class="bg-blue-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ url('/dashboard') }}" class="text-white text-xl font-bold">
                    <i class="fas fa-flask mr-2"></i>Laboratorio DIALAB
                </a>
            </div>

            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="{{ url('/dashboard') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md">
                        <i class="fas fa-tachometer-alt mr-1"></i>Panel Principal
                    </a>
                    <a href="{{ url('/pacientes') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md">
                        <i class="fas fa-users mr-1"></i>Pacientes
                    </a>
                    <a href="{{ url('/ordenes') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md">
                        <i class="fas fa-file-medical mr-1"></i>Órdenes
                    </a>
                    <a href="{{ url('/muestras') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md">
                        <i class="fas fa-vial mr-1"></i>Muestras
                    </a>
                    <a href="{{ url('/resultados') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md">
                        <i class="fas fa-file-pdf mr-1"></i>Resultados
                    </a>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <span class="text-white">
                    <i class="fas fa-user mr-1"></i>{{ Auth::user()->nombre_completo }}
                </span>
                <span class="text-blue-200 text-sm capitalize">({{ Auth::user()->rol }})</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md">
                        <i class="fas fa-sign-out-alt mr-1"></i>Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>