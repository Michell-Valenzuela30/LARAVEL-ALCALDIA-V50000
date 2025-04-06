<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // O Imagick\Driver si usas Imagick
use Intervention\Image\Encoders\WebpEncoder; // Para especificar la codificación WebP

class ConfigurationController extends Controller
{
    public function index()
    {
        $generalConfigs = Configuration::where('group', 'general')->get()->keyBy('key');
        $contactConfigs = Configuration::where('group', 'contact')->get()->keyBy('key');
        $smtpConfigs    = Configuration::where('group', 'smtp')->get()->keyBy('key');

        return view('admin.configuration.index', compact('generalConfigs', 'contactConfigs', 'smtpConfigs'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name'   => 'required|string|max:255',
            'address'    => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'facebook'   => 'nullable|string|max:255',
            'twitter'    => 'nullable|string|max:255',
            'instagram'  => 'nullable|string|max:255',
            'logo_light' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'logo_dark'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Guardar las configuraciones de texto (no archivos)
        foreach ($validated as $key => $value) {
            if ($request->hasFile($key)) {
                continue;
            }
            $group = in_array($key, ['app_name']) ? 'general' : 'contact';
            Configuration::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group]
            );
        }

        // Procesar las imágenes de logos con Intervention Image
        $manager = new ImageManager(new Driver());
        $logoDirectory = public_path('img/logo');
        if (!File::exists($logoDirectory)) {
            File::makeDirectory($logoDirectory, 0755, true);
        }

        $defaultLogos = [
            'Img/Logo/logo_light.svg',
            'Img/Logo/logo_dark.svg'
        ];

        $processLogo = function ($fileKey, $configKey) use ($request, $manager, $logoDirectory, $defaultLogos) {
            if ($request->hasFile($fileKey)) {
                $logoFile = $request->file($fileKey);
                $originalName = pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $hash = Carbon::now()->format('d-m-YHis');
                $newName = $originalName . '-' . $hash . '.webp';
                $imagePath = $logoDirectory . '/' . $newName;
                $dbPath = 'img/logo/' . $newName;

                $previous = Configuration::where('key', $configKey)->first();
                if ($previous && $previous->value && !in_array($previous->value, $defaultLogos)) {
                    $prevPath = public_path($previous->value);
                    if (File::exists($prevPath)) {
                        File::delete($prevPath);
                    }
                }

                $image = $manager->read($logoFile->getRealPath());
                $image->encode(new WebpEncoder(quality: 80))->save($imagePath);

                Configuration::updateOrCreate(
                    ['key' => $configKey],
                    ['value' => $dbPath, 'group' => 'general']
                );
            }
        };

        $processLogo('logo_light', 'logo_light');
        $processLogo('logo_dark', 'logo_dark');

        Artisan::call('config:cache');

        return redirect()->route('configuration.index')->with('success', 'Configuración actualizada con éxito');
    }

    public function updateSmtp(Request $request)
    {
        $validated = $request->validate([
            'mail_mailer'      => 'required|string',
            'mail_host'        => 'required|string',
            'mail_port'        => 'required|numeric',
            'mail_username'    => 'nullable|string',
            'mail_password'    => 'nullable|string',
            'mail_encryption'  => 'nullable|string',
            'mail_from_address' => 'required|email',
            'mail_from_name'   => 'required|string',
        ]);

        foreach ($validated as $key => $value) {
            Configuration::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'smtp']
            );
        }

        // Actualizar archivo .env
        $this->updateEnvFile($validated);

        return redirect()->route('configuration.index')->with('success', 'Configuración SMTP actualizada con éxito');
    }

    private function updateEnvFile($configs)
    {
        $envFilePath = app()->environmentFilePath();
        $envContent = File::get($envFilePath);

        foreach ($configs as $key => $value) {
            $key = strtoupper($key);

            // Si el valor contiene espacios o caracteres especiales, encerrarlo en comillas
            if (strpos($value, ' ') !== false || preg_match('/[^A-Za-z0-9_.]/', $value)) {
                $value = '"' . $value . '"';
            }

            // Actualizar la entrada en el archivo .env
            if (strpos($envContent, "$key=") !== false) {
                $envContent = preg_replace("/^$key=.*$/m", "$key=$value", $envContent);
            } else {
                $envContent .= "\n$key=$value";
            }
        }

        File::put($envFilePath, $envContent);

        // Limpiar la caché de configuración
        Artisan::call('config:clear');
    }
}
