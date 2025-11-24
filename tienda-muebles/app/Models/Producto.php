<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'materiales',
        'dimensiones',
        'color_principal',
        'destacado',
        'imagen_principal',
    ];

    // Casteamos los campos específicos
    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'destacado' => 'boolean',
    ];

    /**
     * Relación: un producto pertenece a muchas categorías (N:M)
     */
    public function categorias()
    {
        return $this->belongsToMany(
            Categoria::class,
            'categoria_producto',
            'producto_id',
            'categoria_id'
        );
    }

    /**
     * Relación: un producto tiene una galería (1:1)
     */
    public function galeria()
    {
        return $this->hasOne(Galeria::class, 'producto_id');
    }

    /**
     * Relación: un producto puede estar en muchos items de carrito (1:N)
     */
    public function carritoItems()
    {
        return $this->hasMany(CarritoItem::class, 'producto_id');
    }

    /**
     * Scope: productos destacados
     */
    public function scopeDestacados($query)
    {
        return $query->where('destacado', true);
    }

    /**
     * Scope: productos con stock disponible
     */
    public function scopeDisponibles($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope: filtrar por categorías
     */
    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->whereHas('categorias', function($q) use ($categoriaId) {
            $q->where('categorias.id', $categoriaId);
        });
    }

    /**
     * Scope: filtrar por rango de precio
     */
    public function scopePorPrecio($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('precio', '>=', $min);
        }
        if ($max) {
            $query->where('precio', '<=', $max);
        }
        return $query;
    }

    /**
     * Scope: filtrar por color
     */
    public function scopePorColor($query, $color)
    {
        return $query->where('color_principal', $color);
    }

    /**
     * Método helper: verificar si hay stock
     */
    public function tieneStock($cantidad = 1)
    {
        return $this->stock >= $cantidad;
    }

    /**
     * Método helper: reducir stock
     */
    public function reducirStock($cantidad)
    {
        if ($this->tieneStock($cantidad)) {
            $this->stock -= $cantidad;
            $this->save();
            return true;
        }
        return false;
    }
}
