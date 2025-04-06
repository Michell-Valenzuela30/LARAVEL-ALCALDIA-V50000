<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ session('theme', 'dark') === 'light' ? 'dark' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Acceso restringido a la sección solicitada.">
    <meta name="keywords" content="acceso, restringido, error, permisos">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acceso Restringido</title>
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
    <!-- Logo en la parte superior -->
    <div class="logo-container flex justify-center mt-10 mb-4">
        <div
            class="w-24 h-24 bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center p-2 border-4 border-primary">
            <!-- Reemplazar con el logo real de tu sistema -->
            <i class="fas fa-lock text-white text-2xl"></i>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="flex-grow flex items-center justify-center px-4">
        <div class="content-container text-center p-8 max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-xl">

            <h1 class="text-2xl sm:text-3xl font-bold mt-6 mb-4 text-red-600 dark:text-red-400 animate-fadeIn">Acceso
                Restringido</h1>

            <div class="bg-red-100 dark:bg-red-900/30 p-4 rounded-lg mb-6 animate-slideInUp">
                <p class="mb-2 text-gray-700 dark:text-gray-300">No tienes permisos para acceder a esta sección.</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Si crees que deberías tener acceso, contacta al
                    administrador del sistema.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('dashboard') }}"
                    class="btn btn-primary inline-flex items-center justify-center hover-shake">
                    <i class="fas fa-home mr-2"></i>
                    Volver al Dashboard
                </a>

                <a href="https://wa.me/584247217960?text=Hola,%20necesito%20ayuda%20con%20un%20problema%20de%20acceso"
                    target="_blank"
                    class="inline-flex items-center justify-center transition-all bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded hover-shake">
                    <i class="fab fa-whatsapp mr-2 text-lg"></i>
                    Reportar problema
                </a>

            </div>
        </div>
    </div>

    <!-- Footer con nombre del sistema -->
    <footer class="footer py-2 mt-auto bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-center md:text-left">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        &copy; {{ date('Y') }} <span
                            class="font-semibold text-primary">{{ config('app.name', 'Sistema de Gestión') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    @vite('resources/js/views/Errors/acceso-restringido.js')
</body>

</html>
