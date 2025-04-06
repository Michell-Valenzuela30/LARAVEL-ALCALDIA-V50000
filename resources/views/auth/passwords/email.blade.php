@extends('layouts.auth')

@section('title', 'Recuperar Contraseña')

@section('auth-content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 w-full max-w-md animate-slideInUp">
        <!-- Encabezado con logo -->
        <div class="logo-container mb-6">
            <a href="/" class="flex items-center justify-center">
                @php
                    $logoLight = config('site_config.logo_light', 'Img/Logo/logo_light.svg');
                    $logoDark = config('site_config.logo_dark', 'Img/Logo/logo_dark.svg');
                @endphp
                <img src="{{ asset($logoLight) }}" alt="Logo" class="h-10 w-auto mr-2 hidden dark:block"
                    onerror="this.src='{{ asset('Img/Logo/logo_dark.svg') }}'; this.onerror=null;">
                <img src="{{ asset($logoDark) }}" alt="Logo" class="h-10 w-auto mr-2 block dark:hidden"
                    onerror="this.src='{{ asset('Img/Logo/logo_light.svg') }}'; this.onerror=null;">
            </a>
        </div>
        <h2 class="text-2xl font-semibold text-center text-gray-800 dark:text-gray-100 mb-4">¿Olvidaste tu contraseña?</h2>

        @if (session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-blue-500">
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-300">Enviar enlace de reseteo</button>
        </form>
    </div>
</div>
@endsection
