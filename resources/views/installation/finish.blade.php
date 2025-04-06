@extends('installation.layout')

@section('content')
    <h2 class="welcome-heading">Finalizar Instalación</h2>
    <p class="mb-4">Últimos ajustes para completar la configuración del sistema y poner en marcha tu aplicación.</p>

    @if(isset($token))
    <div class="note-container" style="background-color: rgba(16, 185, 129, 0.1); border-left: 4px solid var(--success-color);">
        <div class="note-heading">
            <i class="fas fa-check-circle" style="color: var(--success-color);"></i> ¡Usuario Root creado con éxito!
        </div>
        <p>Se ha generado un token de API para el usuario Root. <strong>Guárdalo en un lugar seguro</strong>, ya que no podrás verlo nuevamente:</p>
        <div class="bg-dark text-white p-3 mt-2 rounded d-flex justify-content-between align-items-center">
            <code id="token-text" class="user-select-all" style="word-break: break-all;">{{ $token }}</code>
            <button
                type="button"
                class="btn btn-sm btn-outline-light copy-token ms-3"
                title="Copiar al portapapeles"
                onclick="copyToClipboard('{{ $token }}')"
            >
                <i class="fas fa-copy"></i>
            </button>
        </div>
    </div>

    @vite('resources/js/views/Installation/finish.js')
    @endif

    <form method="POST" action="{{ route('installation.finish.save') }}" id="finish_form" class="mt-4">
        @csrf

        <div class="mb-4">
            <label for="app_url" class="form-label">
                <i class="fas fa-globe me-2 text-primary"></i>URL de la Aplicación
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-link"></i></span>
                <input type="url" class="form-control" id="app_url" name="app_url" value="{{ config('app.url') }}"
                       placeholder="https://tudominio.com" required>
            </div>
            <div class="form-text">Esta URL se utilizará para generar enlaces en toda la aplicación.</div>
            @error('app_url')
                <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label d-block">
                <i class="fas fa-server me-2 text-primary"></i>Entorno de Ejecución
            </label>
            <div class="d-flex gap-4 mt-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="environment" id="env_local" value="local" checked>
                    <label class="form-check-label" for="env_local">
                        <i class="fas fa-laptop-code me-1"></i> Desarrollo (local)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="environment" id="env_production" value="production">
                    <label class="form-check-label" for="env_production">
                        <i class="fas fa-building me-1"></i> Producción
                    </label>
                </div>
            </div>
            <div class="form-text">Selecciona el entorno en el que se ejecutará la aplicación.</div>
            @error('environment')
                <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="note-container" style="background-color: rgba(234, 179, 8, 0.1); border-left: 4px solid #eab308;">
                    <div class="note-heading">
                        <i class="fas fa-shield-alt" style="color: #eab308;"></i> Configuración de Seguridad
                    </div>
                    <p>Si seleccionas "Producción", se habilitarán automáticamente las siguientes medidas de seguridad:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="mb-0">
                                <li><i class="fas fa-check-circle me-2"></i>APP_DEBUG se establecerá en false</li>
                                <li><i class="fas fa-check-circle me-2"></i>Se habilitarán cookies seguras para la sesión</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="mb-0">
                                <li><i class="fas fa-check-circle me-2"></i>Se configurarán dominios estatales para Sanctum</li>
                                <li><i class="fas fa-check-circle me-2"></i>Se optimizará el caché de rutas y configuración</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <a href="{{ route('installation.user') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Anterior
    </a>
    <button form="finish_form" type="submit" class="btn btn-primary">
        <i class="fas fa-flag-checkered me-2"></i>Completar Instalación
    </button>
@endsection
