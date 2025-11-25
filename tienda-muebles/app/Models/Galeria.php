<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    use HasFactory;

    protected $table = "galerias";

    protected $fillable = [
        'producto_id',
    ];

    /**
     * Relación: una galería pertenece a un producto (1:1 inversa)
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Relación: una galería tiene muchas imágenes (1:N)
     */
    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'galeria_id')->orderBy('orden');
    }

    /**
     * Método helper: obtener imagen principal
     */
    public function imagenPrincipal()
    {
        return $this->imagenes()->where('es_principal', true)->first();
    }

    /**
     * Método helper: obtener todas las imágenes ordenadas
     */
    public function imagenesOrdenadas()
    {
        return $this->imagenes()->orderBy('orden')->get();
    }
}
