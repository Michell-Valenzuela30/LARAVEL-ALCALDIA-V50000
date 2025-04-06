@extends('installation.layout')

@section('content')
    <div class="text-center mb-4">
        <h3 class="welcome-heading">Bienvenido al Asistente de Instalación</h3>
        <p class="lead">Este asistente te guiará a través del proceso de configuración de tu aplicación Laravel 10 API REST.
        </p>
    </div>

    <div class="note-container">
        <div class="note-heading">
            <i class="fas fa-info-circle fa-lg"></i> Antes de continuar, asegúrate de:
        </div>

        <div class="row g-4">
            <div id="linux-instructions" class="col-md-6">
                <div class="environment-card card h-100">
                    <div class="card-header">
                        <img src="{{ asset('installation/linux.svg') }}" alt="Linux Icon">
                        En cPanel/Linux
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Busca el archivo <code>.env</code> vía File Manager y asigna permisos 644</li>
                            <li>Establece permisos 755 para:
                                <ul>
                                    <li><code>storage/</code> y todos sus subdirectorios</li>
                                    <li><code>bootstrap/cache</code></li>
                                </ul>
                                (Usa "Cambiar Permisos" en File Manager)
                            </li>
                            <li>Configura el documento raíz del dominio/apache a <code>public_html/public</code></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="windows-instructions" class="col-md-6">
                <div class="environment-card card h-100">
                    <div class="card-header">
                        <img src="{{ asset('installation/windows.svg') }}" alt="Windows Icon">
                        En Windows Local
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Verifica que el archivo <code>.env</code> no esté en "solo lectura" (Propiedades del
                                archivo)</li>
                            <li>Asegura permisos de escritura en:
                                <ul>
                                    <li><code>storage\</code> y todos sus subdirectorios</li>
                                    <li><code>bootstrap\cache</code></li>
                                </ul>
                                (Click derecho > Propiedades > Seguridad > Permisos)
                            </li>
                            <li>Configura virtual host en XAMPP/WAMP apuntando a <code>public/</code></li>
                            <li>O usa <code>php artisan serve</code> para desarrollo temporal</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center">
            <span class="badge bg-primary">
                <i class="fas fa-info-circle"></i> En ambos casos verifica que la versión de PHP sea compatible con tu
                aplicación
            </span>
        </div>
    </div>
@endsection

@section('footer')
    <a href="{{ route('installation.requirements') }}" class="btn btn-primary">
        <i class="fa-solid fa-circle-right"></i> Verificar Requisitos
    </a>
@endsection
