<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orden_tipo_analisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordenes_analisis');
            $table->foreignId('tipo_analisis_id')->constrained('tipos_analisis');
            $table->decimal('precio', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_tipo_analisis');
    }
};