<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoridad extends Model
{
    use HasFactory;

    protected $table = 'autoridades';

    protected $fillable = [
        'director_recaudacion',
        'alcalde',
        'jefe_catastro',
        'nombre_alcaldia',
        'rif_alcaldia',
        'fecha_inicio_cargo',
        'activo',
    ];

    /**
     * Obtener la autoridad activa actual
     */
    public static function getActiva()
    {
        return self::where('activo', true)->latest()->first();
    }
}
