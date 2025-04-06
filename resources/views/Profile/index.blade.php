@extends('layouts.admin')

@section('title', 'Mi Perfil')
@section('header', 'Mi Perfil')

@section('content')
    <div class="max-w-4xl mx-auto">
        @if (session('status'))
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-4 mb-6 rounded-md">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <form action="{{ route('perfil.update') }}" method="POST" class="space-y-2">
                    @csrf
                    @method('PUT')

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Información básica -->
                        <div class="space-y-2">
                            <h2 class="text-xl font-semibold border-b pb-2 dark:border-gray-700">Información Personal</h2>

                            <div>
                                <label for="name" class="block mb-1 font-medium">Nombre</label>
                                <input type="text" id="name" name="name" value="{{ auth()->user()->name }}"
                                    class="w-full px-3 py-2 border dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:bg-gray-700">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block mb-1 font-medium">Correo electrónico</label>
                                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                                    class="w-full px-3 py-2 border dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:bg-gray-700">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="direccion" class="block mb-1 font-medium">Dirección</label>
                                <input type="text" id="direccion" name="direccion"
                                    value="{{ auth()->user()->direccion }}"
                                    class="w-full px-3 py-2 border dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:bg-gray-700">
                                @error('direccion')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="telefono" class="block mb-1 font-medium">Teléfono</label>
                                <input type="text" id="telefono" name="telefono" value="{{ auth()->user()->telefono }}"
                                    class="w-full px-3 py-2 border dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:bg-gray-700">
                                @error('telefono')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="role" class="block mb-1 font-medium">Rol</label>
                                <input type="text" id="role"
                                    value="{{ auth()->user()->role ? auth()->user()->role->name : 'Sin rol' }}"
                                    class="w-full px-3 py-2 border dark:border-gray-700 rounded-md bg-gray-100 dark:bg-gray-600"
                                    readonly>
                            </div>
                        </div>

                        <!-- Cambio de contraseña -->
                        <div class="space-y-6">
                            <h2 class="text-xl font-semibold border-b pb-2 dark:border-gray-700">Cambiar Contraseña</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Deja estos campos en blanco si no
                                deseas cambiar tu contraseña.</p>

                            <div>
                                <label for="current_password" class="block mb-1 font-medium">Contraseña actual</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="w-full px-3 py-2 border dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:bg-gray-700">
                                @error('current_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block mb-1 font-medium">Nueva contraseña</label>
                                <input type="password" id="password" name="password"
                                    class="w-full px-3 py-2 border dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:bg-gray-700">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block mb-1 font-medium">Confirmar nueva
                                    contraseña</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full px-3 py-2 border dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary dark:bg-gray-700">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t dark:border-gray-700">
                        <button type="submit"
                            class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-md transition duration-200">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/views/Profile/index.js')
@endpush
