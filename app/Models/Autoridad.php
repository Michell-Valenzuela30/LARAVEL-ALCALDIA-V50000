<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoridad extends Model
{
    use HasFactory;

    protected $table = 'autoridades';

    protected $fillable = [
        'tipo',
        'nombre',
        'fecha_inicio_cargo',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio_cargo' => 'date',
        'activo' => 'boolean',
    ];

    // Tipos de autoridades disponibles
    const TIPOS = [
        'director_recaudacion' => 'Director de Recaudación',
        'alcalde' => 'Alcalde',
        'jefe_catastro' => 'Jefe de Catastro',
    ];

    /**
     * Obtener todas las autoridades activas
     */
    public static function getActivas()
    {
        return self::where('activo', true)->get()->keyBy('tipo');
    }

    /**
     * Obtener autoridad activa por tipo
     */
    public static function getActivaPorTipo($tipo)
    {
        return self::where('tipo', $tipo)->where('activo', true)->first();
    }

    /**
     * Obtener autoridades inactivas agrupadas por tipo
     */
    public static function getInactivas()
    {
        return self::where('activo', false)
            ->orderBy('tipo')
            ->orderBy('fecha_inicio_cargo', 'desc')
            ->get()
            ->groupBy('tipo');
    }

    /**
     * Activar esta autoridad y desactivar las demás del mismo tipo
     */
    public function activar()
    {
        // Primero desactivar otras autoridades del mismo tipo
        self::where('tipo', $this->tipo)
            ->where('id', '!=', $this->id)
            ->update(['activo' => false]);

        // Luego activar esta autoridad
        $this->update(['activo' => true]);
    }

    /**
     * Obtener el nombre del tipo formateado
     */
    public function getTipoNombreAttribute()
    {
        return self::TIPOS[$this->tipo] ?? $this->tipo;
    }
    /**
     * Relación con los datos de alcaldía
     */
    public function alcaldia()
    {
        return $this->hasOne(AlcaldiaInfo::class);
    }

    /**
     * Obtener datos de alcaldía (método estático)
     */
    public static function getDatosAlcaldia()
    {
        return AlcaldiaInfo::getDatos();
    }
}
