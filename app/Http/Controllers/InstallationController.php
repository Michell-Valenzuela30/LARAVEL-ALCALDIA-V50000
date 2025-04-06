<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;

class InstallationController extends Controller
{
    /**
     * Muestra la pantalla de bienvenida
     */
    public function welcome()
    {
        // Verificar si ya está instalado
        if ($this->isInstalled()) {
            return redirect('/');
        }

        return view('installation.welcome');
    }

    /**
     * Verifica los requisitos del sistema
     */
    public function requirements()
    {
        // Verificar si ya está instalado
        if ($this->isInstalled()) {
            return redirect('/');
        }

        $requirements = $this->checkRequirements();

        return view('installation.requirements', compact('requirements'));
    }

    /**
     * Formulario para configurar la base de datos
     */
    public function database()
    {
        // Verificar si ya está instalado
        if ($this->isInstalled()) {
            return redirect('/');
        }

        return view('installation.database');
    }

    /**
     * Guarda la configuración de la base de datos
     */
    public function saveDatabase(Request $request)
    {
        // Verificar si ya está instalado
        if ($this->isInstalled()) {
            return redirect('/');
        }

        try {
            $request->validate([
                'database_type' => 'required|in:mysql,sqlite',
                'database_host' => 'required_if:database_type,mysql',
                'database_port' => 'required_if:database_type,mysql',
                'database_name' => 'required_if:database_type,mysql',
                'database_user' => 'required_if:database_type,mysql',
            ]);

            $databaseType = $request->input('database_type');

            // Ruta del archivo .env
            $envPath = base_path('.env');
            $envFile = file_get_contents($envPath);

            if ($databaseType === 'mysql') {
                // Para MySQL: Actualizamos o agregamos las variables y las descomentamos
                $envFile = $this->setEnvValue($envFile, 'DB_CONNECTION', 'mysql');
                $envFile = $this->setEnvValue($envFile, 'DB_HOST', $request->input('database_host'));
                $envFile = $this->setEnvValue($envFile, 'DB_PORT', $request->input('database_port'));
                $envFile = $this->setEnvValue($envFile, 'DB_DATABASE', $request->input('database_name'));
                $envFile = $this->setEnvValue($envFile, 'DB_USERNAME', $request->input('database_user'));
                $envFile = $this->setEnvValue($envFile, 'DB_PASSWORD', $request->input('database_password', ''));
            } else {
                // Para SQLite: Establecemos la conexión y comentamos las variables de MySQL
                $envFile = $this->setEnvValue($envFile, 'DB_CONNECTION', 'sqlite');
                $sqlitePath = database_path('database.sqlite');
                $envFile = $this->commentEnvValue($envFile, 'DB_HOST', '127.0.0.1');
                $envFile = $this->commentEnvValue($envFile, 'DB_PORT', '3306');
                $envFile = $this->commentEnvValue($envFile, 'DB_DATABASE', $sqlitePath);
                $envFile = $this->commentEnvValue($envFile, 'DB_USERNAME', 'root');
                $envFile = $this->commentEnvValue($envFile, 'DB_PASSWORD', '');

                // Crear el archivo SQLite si no existe
                if (!File::exists($sqlitePath)) {
                    File::put($sqlitePath, '');
                }
            }

            // Escribir los cambios en el archivo .env
            file_put_contents($envPath, $envFile);

            // Limpiar la caché de configuración
            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            return redirect()->route('installation.user');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar la configuración: ' . $e->getMessage());
        }
    }

    public function testConnection(Request $request)
    {
        // Validamos los parámetros recibidos (puedes ajustar las validaciones según necesites)
        $request->validate([
            'database_host' => 'required',
            'database_port' => 'required',
            'database_name' => 'required',
            'database_user' => 'required',
        ]);

        $host = $request->input('database_host');
        $port = $request->input('database_port');
        $database = $request->input('database_name');
        $username = $request->input('database_user');
        $password = $request->input('database_password');

        // Creamos la configuración de conexión de forma dinámica
        $config = [
            'driver' => 'mysql',
            'host' => $host,
            'port' => $port,
            'database' => $database,
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ];

        try {
            // Purge (limpiar) cualquier conexión previa y establecer una nueva conexión "testconnection"
            DB::purge('testconnection');
            config(['database.connections.testconnection' => $config]);
            // Intentamos obtener el objeto PDO de la conexión de prueba
            DB::connection('testconnection')->getPdo();

            return response()->json([
                'success' => true,
                'message' => 'Conexión exitosa a la base de datos.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de conexión: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Actualiza o agrega una variable en el contenido de .env y se asegura de descomentarla
     */
    private function setEnvValue($envFile, $key, $value)
    {
        // Buscamos la variable, ya sea comentada o no
        $pattern = "/^(#\s*)?{$key}=.*/m";
        $replacement = "{$key}={$value}";
        if (preg_match($pattern, $envFile)) {
            return preg_replace($pattern, $replacement, $envFile);
        } else {
            // Si la variable no existe, la agregamos al final
            return $envFile . "\n" . $replacement;
        }
    }

    /**
     * Comenta o actualiza una variable en el contenido de .env
     */
    private function commentEnvValue($envFile, $key, $value)
    {
        $pattern = "/^(#\s*)?{$key}=.*/m";
        $replacement = "#{$key}={$value}";
        if (preg_match($pattern, $envFile)) {
            return preg_replace($pattern, $replacement, $envFile);
        } else {
            // Si la variable no existe, la agregamos al final
            return $envFile . "\n" . $replacement;
        }
    }

    /**
     * Formulario para crear el usuario root
     */
    public function user()
    {
        // Verificar si ya está instalado
        if ($this->isInstalled()) {
            return redirect('/');
        }

        return view('installation.user');
    }

    /**
     * Guarda el usuario root y ejecuta las migraciones
     */
    public function saveUser(Request $request)
    {
        // Verificar si ya está instalado
        if ($this->isInstalled()) {
            return redirect('/');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        try {
            Artisan::call('migrate:fresh', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);

            // Crear rol Root
            $role = Role::firstOrCreate(['name' => 'root']);
            Role::firstOrCreate(['name' => 'admin']);
            Role::firstOrCreate(['name' => 'user']);

            // Crear usuario Root
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'direccion' => $request->input('direccion'),
                'telefono' => $request->input('telefono'),
                'role_id' => $role->id,
            ]);

            // Crear token personal para el usuario root
            $token = $user->createToken('api-token', ['*'], now()->addYear());

            session(['root_token' => $token->plainTextToken]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al migrar la base de datos: ' . $e->getMessage());
        }

        return redirect()->route('installation.finish');
    }


    /**
     * Formulario para configurar URL y entorno
     */
    public function finish()
    {
        // Verificar si ya está instalado
        if ($this->isInstalled()) {
            return redirect('/');
        }

        $token = session('root_token');

        return view('installation.finish', compact('token'));
    }

    /**
     * Finaliza la instalación
     */
    public function saveFinish(Request $request)
    {
        // Verificar si ya está instalado
        if ($this->isInstalled()) {
            return redirect('/');
        }

        $request->validate([
            'app_url' => 'required|url',
            'environment' => 'required|in:local,production',
        ]);

        // Modificar archivo .env
        $envFile = file_get_contents(base_path('.env'));

        $envFile = preg_replace('/APP_URL=.*/', 'APP_URL=' . $request->input('app_url'), $envFile);
        $envFile = preg_replace('/APP_ENV=.*/', 'APP_ENV=' . $request->input('environment'), $envFile);

        if ($request->input('environment') === 'production') {
            $envFile = preg_replace('/APP_DEBUG=.*/', 'APP_DEBUG=false', $envFile);

            // Agregar configuraciones de seguridad adicionales para producción
            if (!preg_match('/SESSION_SECURE_COOKIE=.*/', $envFile)) {
                $envFile .= "\nSESSION_SECURE_COOKIE=true";
            } else {
                $envFile = preg_replace('/SESSION_SECURE_COOKIE=.*/', 'SESSION_SECURE_COOKIE=true', $envFile);
            }

            if (!preg_match('/SANCTUM_STATEFUL_DOMAINS=.*/', $envFile)) {
                $domain = parse_url($request->input('app_url'), PHP_URL_HOST);
                $envFile .= "\nSANCTUM_STATEFUL_DOMAINS={$domain}";
            }
        } else {
            $envFile = preg_replace('/APP_DEBUG=.*/', 'APP_DEBUG=true', $envFile);
        }

        file_put_contents(base_path('.env'), $envFile);

        // Crear archivo .installed para indicar que la instalación está completa
        File::put(storage_path('.installed'), date('Y-m-d H:i:s'));

        // Limpiar caché
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return redirect('/')->with('success', 'Instalación completada con éxito');
    }

    /**
     * Verifica si la aplicación ya está instalada
     */
    private function isInstalled()
    {
        return File::exists(storage_path('.installed'));
    }

    /**
     * Verifica los requisitos del sistema
     */
    private function checkRequirements()
    {
        $requirements = [
            'php_version' => [
                'name' => 'Versión de PHP >= 8.1',
                'result' => version_compare(PHP_VERSION, '8.1.0', '>='),
                'current' => PHP_VERSION
            ],
            'openssl' => [
                'name' => 'OpenSSL PHP Extension',
                'result' => extension_loaded('openssl'),
                'current' => extension_loaded('openssl') ? 'Instalado' : 'No instalado'
            ],
            'pdo' => [
                'name' => 'PDO PHP Extension',
                'result' => extension_loaded('pdo'),
                'current' => extension_loaded('pdo') ? 'Instalado' : 'No instalado'
            ],
            'mbstring' => [
                'name' => 'Mbstring PHP Extension',
                'result' => extension_loaded('mbstring'),
                'current' => extension_loaded('mbstring') ? 'Instalado' : 'No instalado'
            ],
            'tokenizer' => [
                'name' => 'Tokenizer PHP Extension',
                'result' => extension_loaded('tokenizer'),
                'current' => extension_loaded('tokenizer') ? 'Instalado' : 'No instalado'
            ],
            'xml' => [
                'name' => 'XML PHP Extension',
                'result' => extension_loaded('xml'),
                'current' => extension_loaded('xml') ? 'Instalado' : 'No instalado'
            ],
            'ctype' => [
                'name' => 'Ctype PHP Extension',
                'result' => extension_loaded('ctype'),
                'current' => extension_loaded('ctype') ? 'Instalado' : 'No instalado'
            ],
            'json' => [
                'name' => 'JSON PHP Extension',
                'result' => extension_loaded('json'),
                'current' => extension_loaded('json') ? 'Instalado' : 'No instalado'
            ],
            'bcmath' => [
                'name' => 'BCMath PHP Extension',
                'result' => extension_loaded('bcmath'),
                'current' => extension_loaded('bcmath') ? 'Instalado' : 'No instalado'
            ],
            'fileinfo' => [
                'name' => 'Fileinfo PHP Extension',
                'result' => extension_loaded('fileinfo'),
                'current' => extension_loaded('fileinfo') ? 'Instalado' : 'No instalado'
            ],
            'writable_env' => [
                'name' => 'Archivo .env con permisos de escritura',
                'result' => is_writable(base_path('.env')),
                'current' => is_writable(base_path('.env')) ? 'Escribible' : 'No escribible'
            ],
            'writable_storage' => [
                'name' => 'Directorio storage con permisos de escritura',
                'result' => is_writable(storage_path()),
                'current' => is_writable(storage_path()) ? 'Escribible' : 'No escribible'
            ],
            'server_software' => [
                'name' => 'Software de servidor',
                'result' => true,
                'current' => $_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido'
            ]
        ];

        return $requirements;
    }
}
