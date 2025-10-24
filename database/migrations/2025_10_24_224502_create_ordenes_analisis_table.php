<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_analisis', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_orden')->unique();
            $table->foreignId('paciente_id')->constrained('pacientes');
            $table->foreignId('medico_solicitante')->nullable()->constrained('usuarios');
            $table->text('diagnostico_presuntivo')->nullable();
            $table->date('fecha_solicitud');
            $table->date('fecha_entrega_estimada')->nullable();
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['Pendiente', 'En Proceso', 'Completada', 'Cancelada'])->default('Pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_analisis');
    }
};