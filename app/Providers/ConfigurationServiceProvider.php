<?php

namespace App\Providers;

use App\Models\Configuration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ConfigurationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Verificar si la base de datos está lista antes de cargar configuraciones
        if ($this->databaseIsReady()) {
            $this->loadConfigurations();
        }
    }

    /**
     * Verifica si la base de datos está lista para consultas.
     */
    protected function databaseIsReady(): bool
    {
        try {
            // Evitar errores en local si SQLite no tiene archivo
            if (config('database.default') === 'sqlite') {
                $databasePath = config('database.connections.sqlite.database');
                if ($databasePath && $databasePath !== ':memory:' && !file_exists($databasePath)) {
                    return false;
                }
            }

            // Comprobamos si la conexión a la base de datos es válida
            DB::connection()->getPdo();

            // Si la tabla no existe, no intentamos cargar configuraciones
            return Schema::hasTable('configurations');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Carga las configuraciones desde la base de datos.
     */
    protected function loadConfigurations()
    {
        try {
            $configurations = Configuration::all();

            foreach ($configurations as $config) {
                if ($config->key === 'app_name') {
                    config(['app.name' => $config->value]);
                }

                // Guardar todas las configuraciones en un arreglo accesible
                config(['site_config.' . $config->key => $config->value]);
            }
        } catch (\Exception $e) {
            // Registrar el error en los logs sin interrumpir la aplicación
            logger()->error('Error al cargar configuraciones: ' . $e->getMessage());
        }
    }
}
