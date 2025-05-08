<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CedulaCatastral extends Model
{
    use HasFactory;

    protected $table = 'cedulas_catastrales';

    protected $fillable = [
        'numero_cedula',
        'numero_expediente',
        'propietario_id',
        'direccion_inmueble',
        'tipo_inmueble',
        'ambito',
        'linderos_id',
        'documento_legal_id',
        'avaluo_total',
        'fecha_expedicion',
        'vigencia_trimestre',
        'solicitado_para',
        'dato_opcional_1',
        'dato_opcional_2',
        'dato_opcional_3',
        'dato_opcional_texto',
    ];

    /**
     * Obtener el propietario asociado a esta cédula catastral
     */
    public function propietario()
    {
        return $this->belongsTo(Propietario::class, 'propietario_id');
    }

    /**
     * Obtener los linderos asociados a esta cédula catastral
     */
    public function linderos()
    {
        return $this->belongsTo(Lindero::class, 'linderos_id');
    }

    /**
     * Obtener el documento legal asociado a esta cédula catastral
     */
    public function documentoLegal()
    {
        return $this->belongsTo(DocumentoLegal::class, 'documento_legal_id');
    }

    /**
     * Obtener las solvencias municipales asociadas a esta cédula catastral
     */
    public function solvenciasMunicipales()
    {
        return $this->hasMany(SolvenciaMunicipal::class, 'cedula_catastral_id');
    }
}
