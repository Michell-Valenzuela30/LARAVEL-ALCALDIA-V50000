<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catastro extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'catastros';
    protected $primaryKey = 'id_cat';

    protected $fillable = [
        'num_expe',
        'nom_ape',
        'ced',
        'direccion',
        'tipo',
        'descripcion',
    ];
}
