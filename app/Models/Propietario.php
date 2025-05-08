<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory;

    protected $table = 'propietarios';

    protected $fillable = [
        'nombre_apellido',
        'cedula',
        'rif',
    ];

    /**
     * Obtener las cédulas catastrales asociadas a este propietario
     */
    public function cedulasCatastrales()
    {
        return $this->hasMany(CedulaCatastral::class, 'propietario_id');
    }

    /**
     * Obtener las solvencias municipales asociadas a este propietario
     */
    public function solvenciasMunicipales()
    {
        return $this->hasMany(SolvenciaMunicipal::class, 'propietario_id');
    }
}
