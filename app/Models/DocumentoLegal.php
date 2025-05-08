<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoLegal extends Model
{
    use HasFactory;

    protected $table = 'documentos_legales';

    protected $fillable = [
        'tipo',
        'numero',
        'matricula',
        'folio',
        'fecha',
        'descripcion',
    ];

    /**
     * Obtener la cédula catastral asociada a este documento legal
     */
    public function cedulaCatastral()
    {
        return $this->hasOne(CedulaCatastral::class, 'documento_legal_id');
    }
}
