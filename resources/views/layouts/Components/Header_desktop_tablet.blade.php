<!-- Header para desktop/tablet -->
<header class="bg-white dark:bg-gray-800 shadow-sm py-3 px-4 flex justify-between items-center">

    <h1 class="text-xl font-semibold">@yield('header', 'Dashboard')</h1>
    <div class="flex items-center space-x-4">
        <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
            <i class="fas fa-sun dark:hidden"></i>
            <i class="fas fa-moon hidden dark:block"></i>
        </button>
        <div class="relative">
            <button id="user-menu-button" class="flex items-center">
                <span class="mr-2 hidden sm:inline-block">{{ auth()->user()->name ?? 'Usuario' }}</span>
                <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                    <i class="fas fa-user text-gray-600 dark:text-gray-300"></i>
                </div>
            </button>
            <!-- Dropdown menu -->
            <div id="user-dropdown"
                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 hidden z-10">
                <a href="{{ route('perfil.show') }}"
                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Perfil
                </a>
                <button id="logout-dropdown-btn"
                    class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Cerrar Sesión
                </button>
            </div>
        </div>
    </div>
</header>
