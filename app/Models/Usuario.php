<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'email',
        'contrasena',
        'rol',
        'activo'
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function esAdministrador()
    {
        return $this->rol === 'administrador';
    }

    public function esRecepcionista()
    {
        return $this->rol === 'recepcionista';
    }

    public function esBioquimico()
    {
        return $this->rol === 'bioquimico';
    }
}