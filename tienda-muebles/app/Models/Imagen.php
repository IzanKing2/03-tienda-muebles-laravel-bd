<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'imagenes';

    protected $fillable = [
        'galeria_id',
        'ruta',
        'es_principal',
        'orden',
    ];

    protected $casts = [
        'es_principal' => 'boolean',
        'orden' => 'integer',
    ];

    /**
     * Relación: una imagen pertenece a una galería (1:1)
     */
    public function galeria()
    {
        return $this->belongsTo(Galeria::class, 'galeria_id');
    }

    /**
     * Método helper: obtener URL completa de la imagen
     */
    public function url()
    {
        return asset('storage/' . $this->ruta);
    }

    /**
     * Método helper: eliminar archivo físico
     */
    public function eliminarArchivo()
    {
        if (Storage::disk('public')->exists($this->ruta)) {
            Storage::disk('public')->delete($this->ruta);
        }
    }

    /**
     * Método helper: establecer como principal
     */
    public function establecerComoPrincipal()
    {
        // Quitar principal de todas las demás imágenes de la galería
        Imagen::where('galeria_id', $this->galeria_id)
            ->where('id', '!=', $this->id)
            ->update(['es_principal' => false]);
        
        // Establecer esta como principal
        $this->es_principal = true;
        $this->save();
    }

    /**
     * Event: Al eliminar imagen, borrar archivo físico
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($imagen) {
            $imagen->eliminarArchivo();
        });
    }
}
