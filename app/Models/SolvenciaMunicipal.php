<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolvenciaMunicipal extends Model
{
    use HasFactory;

    protected $table = 'solvencias_municipales';

    protected $fillable = [
        'numero_solvencia',
        'propietario_id',
        'cedula_catastral_id',
        'direccion_inmueble',
        'solicitado_para',
        'vigencia_desde',
        'vigencia_hasta',
        'fecha_expedicion',
        'vigencia_trimestre',
    ];

    /**
     * Obtener el propietario asociado a esta solvencia municipal
     */
    public function propietario()
    {
        return $this->belongsTo(Propietario::class, 'propietario_id');
    }

    /**
     * Obtener la cédula catastral asociada a esta solvencia municipal
     */
    public function cedulaCatastral()
    {
        return $this->belongsTo(CedulaCatastral::class, 'cedula_catastral_id');
    }
}
