<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lindero extends Model
{
    use HasFactory;

    protected $table = 'linderos';

    protected $fillable = [
        'norte',
        'sur',
        'este',
        'oeste',
        'mt2_norte',
        'mt2_sur',
        'mt2_este',
        'mt2_oeste',
        'mt2_total',
    ];

    /**
     * Obtener la cédula catastral asociada a estos linderos
     */
    public function cedulaCatastral()
    {
        return $this->hasOne(CedulaCatastral::class, 'linderos_id');
    }
}
