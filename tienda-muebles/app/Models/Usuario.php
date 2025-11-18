<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'rol_id',
        'nombre',
        'apellidos',
        'email',
        'password',
        'intentos_fallidos',
        'bloqueado_hasta',
    ];

    // Ocultar campos sensibles al convertir a JSON
    protected $hidden = [
        'password',
    ];

    // Casteamos los campos a tipos específicos
    protected $casts = [
        'bloqueado_hasta' => 'datetime',
        'intentos_fallidos' => 'integer',
    ];

    /**
     * Relación: un usuario pertenece a un rol
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    /**
     * Relación: un usuario tiene muchos carritos
     */
    public function carritos()
    {
        return $this->hasMany(Carrito::class, 'usuario_id');
    }

    /**
     * Hash: Hashear password automáticamente
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Método helper: verificar si está bloqueado
     */
    public function estaBloqueado()
    {
        return $this->bloqueado_hasta;
    }
}
