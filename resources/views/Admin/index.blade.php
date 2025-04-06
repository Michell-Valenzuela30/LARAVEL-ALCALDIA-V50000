@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Tarjeta de estadística - Usuarios -->
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold opacity-80">Usuarios</h3>
                    <p class="text-2xl font-bold mt-1" id="total-usuarios">--</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm">
                <span id="nuevos-usuarios">--</span> nuevos este mes
            </div>
        </div>

        <!-- Tarjeta de estadística - Placeholder 1 -->
        <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold opacity-80">Estadística 2</h3>
                    <p class="text-2xl font-bold mt-1">0</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm">
                Datos de ejemplo
            </div>
        </div>

        <!-- Tarjeta de estadística - Placeholder 2 -->
        <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold opacity-80">Estadística 3</h3>
                    <p class="text-2xl font-bold mt-1">0</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <i class="fas fa-tasks text-2xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm">
                Datos de ejemplo
            </div>
        </div>

        <!-- Tarjeta de estadística - Placeholder 3 -->
        <div class="card bg-gradient-to-br from-amber-500 to-amber-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold opacity-80">Estadística 4</h3>
                    <p class="text-2xl font-bold mt-1">0</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <i class="fas fa-bell text-2xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm">
                Datos de ejemplo
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Actividad reciente -->
        <div class="card lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Actividad reciente</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Usuario</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Acción</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="actividad-reciente">
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap" colspan="3">
                                <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                                    No hay actividad reciente para mostrar
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Enlaces rápidos -->
        <div class="card">
            <h2 class="text-xl font-semibold mb-4">Enlaces rápidos</h2>
            <div class="space-y-3">
                <a href="{{ route('usuarios.index') }}"
                    class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <div class="p-2 rounded-md bg-primary/10 text-primary dark:text-primary-light mr-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="font-medium">Gestionar usuarios</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Administrar usuarios del sistema</p>
                    </div>
                </a>

                <a href="{{ route('configuration.index') }}"
                    class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <div class="p-2 rounded-md bg-green-500/10 text-green-600 dark:text-green-400 mr-3">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div>
                        <h3 class="font-medium">Configuración</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ajustes del sistema</p>
                    </div>
                </a>

                <a href="{{ route('perfil.show') }}"
                    class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <div class="p-2 rounded-md bg-amber-500/10 text-amber-600 dark:text-amber-400 mr-3">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h3 class="font-medium">Mi perfil</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ver y editar tu perfil</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    @vite(['resources/js/views/Admin/dashboard.js'])
    @endpush
@endsection
