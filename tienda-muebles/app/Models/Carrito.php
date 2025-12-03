<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carritos';

    protected $fillable = [
        'usuario_id',
        'sesion_id',
        'total',
    ];

    /**
     * Relación: un carrito pertenece a un usuario (puede ser NULL)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación: un carrito tiene muchos items (1:N)
     */
    public function items()
    {
        return $this->hasMany(CarritoItem::class, 'carrito_id');
    }

    /**
     * Relación: un carrito tiene muchos productos a través de los items
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'carrito_items', 'carrito_id', 'producto_id')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
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
