<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAnalisis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'categoria',
        'tiempo_entrega_horas',
        'activo'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean'
    ];

    // Relación con muestras
    public function muestras()
    {
        return $this->hasMany(Muestra::class);
    }

    // Relación con órdenes (a través de la tabla pivote)
    public function ordenes()
    {
        return $this->belongsToMany(OrdenAnalisis::class, 'orden_tipo_analisis')
                    ->withPivot('precio')
                    ->withTimestamps();
    }

    // Scope para análisis activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Scope por categoría
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }
}