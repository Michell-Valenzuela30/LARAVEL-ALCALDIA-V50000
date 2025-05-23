<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlcaldiaInfo extends Model
{
    use HasFactory;

    protected $table = 'alcaldia_info';

    protected $fillable = [
        'nombre',
        'rif',
    ];

    public static function getInfo()
    {
        return self::first();
    }
}
