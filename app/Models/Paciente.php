<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_completo',
        'ci',
        'edad',
        'sexo',
        'direccion',
        'telefono',
        'email',
        'fecha_registro',
        'observaciones',
        'activo'
    ];

    protected $casts = [
        'fecha_registro' => 'date',
        'activo' => 'boolean'
    ];

    // Relación con órdenes
    public function ordenes()
    {
        return $this->hasMany(OrdenAnalisis::class);
    }

    // Scope para pacientes activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Método para nombre completo
    public function getNombreCompletoAttribute($value)
    {
        return ucwords(strtolower($value));
    }
}