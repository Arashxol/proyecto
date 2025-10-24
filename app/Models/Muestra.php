<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muestra extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_muestra',
        'orden_id',
        'tipo_analisis_id',
        'tipo_muestra',
        'estado',
        'fecha_recoleccion',
        'fecha_analisis',
        'tecnico_asignado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_recoleccion' => 'datetime',
        'fecha_analisis' => 'datetime'
    ];

    // Relación con orden
    public function orden()
    {
        return $this->belongsTo(OrdenAnalisis::class);
    }

    // Relación con tipo de análisis
    public function tipoAnalisis()
    {
        return $this->belongsTo(TipoAnalisis::class);
    }

    // Relación con técnico asignado
    public function tecnico()
    {
        return $this->belongsTo(Usuario::class, 'tecnico_asignado');
    }

    // Relación con resultado
    public function resultado()
    {
        return $this->hasOne(Resultado::class);
    }

    // Método para generar código de muestra
    public static function generarCodigoMuestra()
    {
        $fecha = now()->format('Ymd');
        $ultimaMuestra = self::where('codigo_muestra', 'like', "MU-{$fecha}-%")->latest()->first();
        
        $numero = $ultimaMuestra ? (int) substr($ultimaMuestra->codigo_muestra, -4) + 1 : 1;
        
        return "MU-{$fecha}-" . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // Scope para muestras pendientes de análisis
    public function scopePendientesAnalisis($query)
    {
        return $query->whereIn('estado', ['Recolectada', 'En Transito']);
    }

    // Scope para muestras en análisis
    public function scopeEnAnalisis($query)
    {
        return $query->where('estado', 'En Analisis');
    }
}