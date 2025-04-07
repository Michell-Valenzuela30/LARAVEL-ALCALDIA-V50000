<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ session('theme', 'light') === 'dark' ? 'dark' : '' }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
        <div class="flex flex-col md:flex-row h-screen">
            @auth
                <!-- Sidebar para tablets y desktop -->
                @include('layouts.Components.Sidebar_Tablet_Desktop')

                <!-- Contenido principal -->
                <main class="flex-1 flex flex-col overflow-hidden">
                    <!-- Header para desktop/tablet -->
                    @include('layouts.Components.Header_desktop_tablet')

                    <!-- Contenido -->
                    <div class="flex-1 overflow-y-auto p-4 md:pb-0 pb-16">
                        @yield('content')
                    </div>

                    <!-- Navbar inferior para móviles -->
                    @include('layouts.Components.Navbar_movil')
                </main>
            @else
                @yield('auth-content')
            @endauth
        </div>

        <!-- Modal Base -->
        <div id="modal-base" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div id="modal-content">
                    <!-- El contenido del modal se cargará dinámicamente -->
                </div>
            </div>
        </div>

        @vite('resources/js/views/layouts/adminLayout.js')

        @stack('scripts')
    </body>

</html>
