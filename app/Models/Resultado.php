<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = [
        'muestra_id',
        'resultado',
        'valores_referencia',
        'interpretacion',
        'bioquimico_validador',
        'fecha_validacion',
        'estado',
        'observaciones_validacion'
    ];

    protected $casts = [
        'fecha_validacion' => 'datetime'
    ];

    // Relación con muestra
    public function muestra()
    {
        return $this->belongsTo(Muestra::class);
    }

    // Relación con bioquímico validador
    public function bioquimico()
    {
        return $this->belongsTo(Usuario::class, 'bioquimico_validador');
    }

    // Scope para resultados pendientes de validación
    public function scopePendientesValidacion($query)
    {
        return $query->where('estado', 'Pendiente');
    }

    // Scope para resultados validados
    public function scopeValidados($query)
    {
        return $query->where('estado', 'Validado');
    }

    // Método para validar resultado
    public function validar($bioquimicoId, $observaciones = null)
    {
        $this->update([
            'estado' => 'Validado',
            'bioquimico_validador' => $bioquimicoId,
            'fecha_validacion' => now(),
            'observaciones_validacion' => $observaciones
        ]);

        // Actualizar estado de la muestra
        $this->muestra->update(['estado' => 'Resultado Listo']);
    }
}