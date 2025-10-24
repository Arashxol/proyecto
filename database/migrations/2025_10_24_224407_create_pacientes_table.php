<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('ci')->unique();
            $table->integer('edad');
            $table->enum('sexo', ['Masculino', 'Femenino']);
            $table->text('direccion');
            $table->string('telefono');
            $table->string('email')->nullable();
            $table->date('fecha_registro');
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};