<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('muestras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_muestra')->unique();
            $table->foreignId('orden_id')->constrained('ordenes_analisis');
            $table->foreignId('tipo_analisis_id')->constrained('tipos_analisis');
            $table->enum('tipo_muestra', ['Sangre', 'Orina', 'Heces', 'Saliva', 'Tejido', 'Otro']);
            $table->enum('estado', ['Recolectada', 'En Transito', 'En Analisis', 'Analizada', 'Resultado Listo', 'Archivada'])->default('Recolectada');
            $table->dateTime('fecha_recoleccion');
            $table->dateTime('fecha_analisis')->nullable();
            $table->foreignId('tecnico_asignado')->nullable()->constrained('usuarios');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('muestras');
    }
};