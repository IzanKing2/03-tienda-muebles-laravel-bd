<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carritos';

    protected $fillable = [
        'usuario_id',
        'sesion_id',
    ];

    /**
     * Relación: un carrito pertenece a un usuario (puede ser NULL)
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Relación: un carrito tiene muchos items (1:N)
     */
    public function items()
    {
        return $this->hasMany(CarritoItem::class, 'carrito_id');
    }

    /**
     * Método helper: calcular subtotal del carrito
     */
    public function calcularSubtotal()
    {
        return $this->items->sum(function ($item) {
            return $item->cantidad * $item->precio_unitario;
        });
    }
}
