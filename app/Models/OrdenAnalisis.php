<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenAnalisis extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_orden',
        'paciente_id',
        'medico_solicitante',
        'diagnostico_presuntivo',
        'fecha_solicitud',
        'fecha_entrega_estimada',
        'total',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_entrega_estimada' => 'date',
        'total' => 'decimal:2'
    ];

    // Relación con paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relación con médico solicitante
    public function medico()
    {
        return $this->belongsTo(Usuario::class, 'medico_solicitante');
    }

    // Relación con muestras
    public function muestras()
    {
        return $this->hasMany(Muestra::class);
    }

    // Relación con tipos de análisis (muchos a muchos)
    public function tiposAnalisis()
    {
        return $this->belongsToMany(TipoAnalisis::class, 'orden_tipo_analisis')
                    ->withPivot('precio')
                    ->withTimestamps();
    }

    // Método para generar código de orden
    public static function generarCodigoOrden()
    {
        $fecha = now()->format('Ymd');
        $ultimaOrden = self::where('codigo_orden', 'like', "ORD-{$fecha}-%")->latest()->first();
        
        $numero = $ultimaOrden ? (int) substr($ultimaOrden->codigo_orden, -4) + 1 : 1;
        
        return "ORD-{$fecha}-" . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // Scope para órdenes pendientes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'Pendiente');
    }

    // Scope para órdenes en proceso
    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'En Proceso');
    }
}