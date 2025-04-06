<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ session('theme', 'light') === 'light' ? 'dark' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Acceso restringido a la sección solicitada.">
    <meta name="keywords" content="acceso, restringido, error, permisos">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 1s ease-out;
        }

        .animate-slideInUp {
            animation: slideInUp 0.8s ease-out;
        }

        .animate-pulse {
            animation: pulse 2s infinite ease-in-out;
        }

        .animate-shake {
            animation: shake 0.5s;
        }

        .logo-container {
            animation: fadeIn 1.5s ease-out;
        }

        .content-container {
            animation: slideInUp 1s ease-out;
        }

        .footer {
            animation: fadeIn 2s ease-out;
        }

        .hover-shake:hover {
            animation: shake 0.5s;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">

    @yield('auth-content')

    @stack('scripts')
</body>

</html>
