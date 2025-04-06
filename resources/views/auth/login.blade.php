@extends('layouts.auth')

@section('title', 'Iniciar Sesión')

@section('auth-content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4">
        <div class="card max-w-md w-full">
            <div class="text-center mb-6">
                <!-- Encabezado con logo -->
                <div class="p-4 flex items-center justify-center">
                    <a href="/" class="flex items-center">
                        @php
                            $logoLight = config('site_config.logo_light', 'Img/Logo/logo_light.svg');
                            $logoDark = config('site_config.logo_dark', 'Img/Logo/logo_dark.svg');
                        @endphp
                        <img src="{{ asset($logoLight) }}" alt="Logo" class="h-18 w-auto mr-2 hidden dark:block"
                            onerror="this.src='{{ asset('Img/Logo/logo_dark.svg') }}'; this.onerror=null;">
                        <img src="{{ asset($logoDark) }}" alt="Logo" class="h-18 w-auto mr-2 block dark:hidden"
                            onerror="this.src='{{ asset('Img/Logo/logo_light.svg') }}'; this.onerror=null;">
                    </a>
                </div>
                <h1 class="text-2xl font-bold text-primary dark:text-primary-light">{{ config('app.name', 'Laravel') }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Inicia sesión para acceder al sistema</p>
            </div>

            <div id="login-error"
                class="mb-4 p-3 bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300 rounded-md hidden"></div>

            <form id="login-form" class="space-y-4">
                <div>
                    <label for="email" class="block mb-1 font-medium">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="input" placeholder="usuario@ejemplo.com" required>
                </div>

                <div>
                    <label for="password" class="block mb-1 font-medium">Contraseña</label>
                    <input type="password" id="password" name="password" class="input" placeholder="••••••••" required>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary dark:bg-gray-700">
                        <label for="remember" class="ml-2 text-sm">Recordarme</label>
                    </div>
                    <div>
                        <!-- Enlace para recuperar contraseña -->
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-full py-3 flex justify-center items-center">
                    <span>Iniciar Sesión</span>
                    <span id="login-spinner" class="ml-2 hidden">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos los derechos reservados.
            </p>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/views/Auth/login.js')
    @endpush
@endsection
