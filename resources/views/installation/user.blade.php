@extends('installation.layout')

@section('content')
    <h2 class="welcome-heading">Configuración de Usuario Root</h2>
    <p class="mb-4">Crea el primer usuario super administrador (Root) del sistema. Este usuario tendrá acceso completo a todas las funcionalidades.</p>

    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="note-container">
        <div class="note-heading">
            <i class="fas fa-shield-alt"></i> Recomendaciones de seguridad
        </div>
        <p class="mb-0">
            Asegúrate de usar una contraseña fuerte que combine letras mayúsculas, minúsculas, números y caracteres especiales.
            El acceso Root permite control total sobre el sistema, protege estas credenciales adecuadamente.
        </p>
    </div>

    <form method="POST" action="{{ route('installation.user.save') }}" id="user_form" class="mt-4">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">
                    <i class="fas fa-user me-2 text-primary"></i>Nombre completo
                </label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                       placeholder="Ingresa tu nombre completo" required>
                @error('name')
                    <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-2 text-primary"></i>Correo Electrónico
                </label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                       placeholder="correo@ejemplo.com" required>
                @error('email')
                    <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-2 text-primary"></i>Contraseña
                </label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Ingresa una contraseña segura" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label">
                    <i class="fas fa-check-circle me-2 text-primary"></i>Confirmar Contraseña
                </label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                           placeholder="Confirma tu contraseña" required>
                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mb-3">
                <label for="direccion" class="form-label">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>Dirección (opcional)
                </label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}"
                       placeholder="Tu dirección física">
            </div>

            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">
                    <i class="fas fa-phone me-2 text-primary"></i>Teléfono (opcional)
                </label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}"
                       placeholder="+XX XXX XXXXXXX">
            </div>
        </div>
    </form>

    @vite('resources/js/views/Installation/user.js')
@endsection

@section('footer')
    <a href="{{ route('installation.database') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Anterior
    </a>
    <button form="user_form" type="submit" class="btn btn-primary">
        <i class="fas fa-user-shield me-2"></i>Crear Usuario Root
    </button>
@endsection
