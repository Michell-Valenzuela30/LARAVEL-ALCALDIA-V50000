<!-- Botón flotante para mostrar/ocultar el Sidebar (solo en móviles/tablets) -->
<button id="sidebar-toggle"
    class="fixed bottom-20 right-4 z-50 p-3 bg-white dark:bg-gray-800 rounded-full shadow-lg transition transform hover:scale-110 lg:hidden">
    <i class="fas fa-bars text-gray-700 dark:text-gray-200 transition duration-300"></i>
</button>

<!-- Sidebar para móviles/tablets y desktop -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-300 ease-in-out z-40 -translate-x-full lg:static lg:translate-x-0">
    <!-- Encabezado con logo -->
    <div class="p-4 flex items-center justify-center">
        <a href="{{ route('dashboard') }}" class="flex items-center">
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

    <!-- Contenedor principal con navegación y botón de logout -->
    <div class="flex flex-col">
        <!-- Navegación principal -->
        <nav class="flex-1 p-4 overflow-y-auto">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 rounded-md {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary dark:text-primary-light' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <i class="fas fa-home w-5 h-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.catastro.index') }}"
                        class="flex items-center p-2 rounded-md {{ request()->routeIs('admin.catastro.index') ? 'bg-primary/10 text-primary dark:text-primary-light' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <i class="fa-solid fa-box-archive w-5 h-5 mr-3"></i>
                        <span>Catastro</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('usuarios.index') }}"
                        class="flex items-center p-2 rounded-md {{ request()->routeIs('usuarios.*') ? 'bg-primary/10 text-primary dark:text-primary-light' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <i class="fas fa-users w-5 h-5 mr-3"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('configuration.index') }}"
                        class="flex items-center p-2 rounded-md {{ request()->routeIs('configuration.*') ? 'bg-primary/10 text-primary dark:text-primary-light' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <i class="fas fa-cog w-5 h-5 mr-3"></i>
                        <span>Configuración</span>
                    </a>
                </li>
                <!-- Puedes agregar más elementos de navegación aquí -->
            </ul>
        </nav>
    </div>
</aside>
