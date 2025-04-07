<!-- Navbar inferior para móviles -->
<nav
    class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 shadow-lg border-t dark:border-gray-700 z-10 h-18">
    <div class="flex justify-around items-center h-18">
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center p-2 {{ request()->routeIs('dashboard') ? 'text-primary dark:text-primary-light' : 'text-gray-600 dark:text-gray-400' }}">
            <i class="fas fa-home"></i>
            <span class="text-xs mt-1">Inicio</span>
        </a>
        <a href="{{ route('admin.catastro.index') }}"
            class="flex flex-col items-center p-2 {{ request()->routeIs('admin.catastro.index') ? 'text-primary dark:text-primary-light' : 'text-gray-600 dark:text-gray-400' }}">
            <i class="fa-solid fa-box-archive"></i>
            <span class="text-xs mt-1">Catastro</span>
        </a>
        <a href="{{ route('configuration.index') }}"
            class="flex flex-col items-center p-2 {{ request()->routeIs('configuration.*') ? 'text-primary dark:text-primary-light' : 'text-gray-600 dark:text-gray-400' }}">
            <i class="fas fa-cog"></i>
            <span class="text-xs mt-1">Config</span>
        </a>
        <button id="logout-mobile-btn" class="flex flex-col items-center p-2 text-red-600 dark:text-red-400">
            <i class="fas fa-sign-out-alt"></i>
            <span class="text-xs mt-1">Salir</span>
        </button>
    </div>
</nav>
