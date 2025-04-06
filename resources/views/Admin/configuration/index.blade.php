@extends('layouts.admin')

@section('title', 'Configuración')
@section('header', 'Configuración del Sistema')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div
                class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded mb-6 flex items-center shadow-md">
                <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Panel de Información General -->
            <div class="lg:col-span-2">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-200 hover:shadow-lg">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-medium text-gray-800 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Información General
                        </h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('configuration.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-6">
                                <label for="app_name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre del Sistema
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9.243 3.03a1 1 0 01.727 1.213L9.53 6h2.94l.56-2.243a1 1 0 111.94.486L14.53 6H17a1 1 0 110 2h-2.97l-1 4H15a1 1 0 110 2h-2.47l-.56 2.242a1 1 0 11-1.94-.485L10.47 14H7.53l-.56 2.242a1 1 0 11-1.94-.485L5.47 14H3a1 1 0 110-2h2.97l1-4H5a1 1 0 110-2h2.47l.56-2.243a1 1 0 011.213-.727zM9.03 8l-1 4h2.938l1-4H9.031z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="app_name" name="app_name"
                                        value="{{ $generalConfigs['app_name']->value ?? config('app.name') }}"
                                        class="pl-10 py-3 focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md">
                                </div>
                            </div>

                            <!-- Sección de logos con mejor estilo -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label for="logo_light"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Logo Modo Claro
                                    </label>
                                    <div
                                        class="relative flex-1 flex justify-center items-center px-6 pt-5 pb-6 border-2 border-black border-dashed rounded-md bg-black text-white transition-all duration-200 hover:border-primary">
                                        <div class="space-y-4 text-center">
                                            <div>
                                                @if(isset($generalConfigs['logo_light']))
                                                    <div class="mb-3 flex justify-center">
                                                        <img src="{{ asset($generalConfigs['logo_light']->value) }}"
                                                            alt="Logo Claro" class="h-16 object-contain">
                                                    </div>
                                                @endif
                                                <svg class="mx-auto h-12 w-12 text-gray-300" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex justify-center text-sm text-white">
                                                    <label for="logo_light"
                                                        class="relative cursor-pointer rounded-md font-medium text-primary hover:text-primary-dark focus-within:outline-none">
                                                        <span>Subir archivo</span>
                                                        <input id="logo_light" name="logo_light" type="file" class="sr-only"
                                                            accept="image/*">
                                                    </label>
                                                </div>
                                                <p class="text-xs text-white mt-1">PNG o SVG transparente recomendado</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label for="logo_dark"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Logo Modo Oscuro
                                    </label>
                                    <div
                                        class="relative flex-1 flex justify-center items-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-white transition-all duration-200 hover:border-primary">
                                        <div class="space-y-4 text-center">
                                            <div>
                                                @if(isset($generalConfigs['logo_dark']))
                                                    <div class="mb-3 flex justify-center">
                                                        <img src="{{ asset($generalConfigs['logo_dark']->value) }}"
                                                            alt="Logo Oscuro" class="h-16 object-contain">
                                                    </div>
                                                @endif
                                                <svg class="mx-auto h-12 w-12 text-gray-300" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex justify-center text-sm text-gray-300">
                                                    <label for="logo_dark"
                                                        class="relative cursor-pointer rounded-md font-medium text-primary hover:text-primary-dark focus-within:outline-none">
                                                        <span>Subir archivo</span>
                                                        <input id="logo_dark" name="logo_dark" type="file" class="sr-only"
                                                            accept="image/*">
                                                    </label>
                                                </div>
                                                <p class="text-xs text-gray-400 mt-1">PNG o SVG transparente recomendado</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="flex justify-end mt-4">
                                <button type="submit"
                                    class="flex items-center justify-center px-1 py-1 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-md transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-sm">Guardar Cambios</p>
                                </button>
                            </div>

                            <div class="pb-2 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-800 dark:text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Información de Contacto
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <!-- Dirección -->
                                <div>
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dirección</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="text" id="address" name="address"
                                            value="{{ $contactConfigs['address']->value ?? '' }}"
                                            class="pl-10 py-3 focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md">
                                    </div>
                                </div>

                                <!-- Teléfono -->
                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Teléfono</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="phone" name="phone"
                                            value="{{ $contactConfigs['phone']->value ?? '' }}"
                                            class="pl-10 py-3 focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                        </div>
                                        <input type="email" id="email" name="email"
                                            value="{{ $contactConfigs['email']->value ?? '' }}"
                                            class="pl-10 py-3 focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-800 dark:text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M6 3a1 1 0 011-1h.01a1 1 0 010 2H7a1 1 0 01-1-1zM11 3a1 1 0 011-1h.01a1 1 0 010 2H12a1 1 0 01-1-1zM16 3a1 1 0 011-1h.01a1 1 0 010 2H17a1 1 0 01-1-1zM6 8a1 1 0 011-1h.01a1 1 0 010 2H7a1 1 0 01-1-1zM11 8a1 1 0 011-1h.01a1 1 0 010 2H12a1 1 0 01-1-1zM16 8a1 1 0 011-1h.01a1 1 0 010 2H17a1 1 0 01-1-1zM6 13a1 1 0 011-1h.01a1 1 0 010 2H7a1 1 0 01-1-1zM11 13a1 1 0 011-1h.01a1 1 0 010 2H12a1 1 0 01-1-1zM16 13a1 1 0 011-1h.01a1 1 0 010 2H17a1 1 0 01-1-1z" />
                                        <path
                                            d="M2 3a1 1 0 011-1h.01a1 1 0 010 2H3a1 1 0 01-1-1zm0 5a1 1 0 011-1h.01a1 1 0 010 2H3a1 1 0 01-1-1zm0 5a1 1 0 011-1h.01a1 1 0 010 2H3a1 1 0 01-1-1z" />
                                    </svg>
                                    Redes Sociales
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                                <!-- Facebook -->
                                <div>
                                    <label for="facebook"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Facebook</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="facebook" name="facebook"
                                            value="{{ $contactConfigs['facebook']->value ?? '' }}"
                                            placeholder="URL o nombre de usuario"
                                            class="pl-10 py-3 focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md">
                                    </div>
                                </div>

                                <!-- Twitter -->
                                <div>
                                    <label for="twitter"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Twitter</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="twitter" name="twitter"
                                            value="{{ $contactConfigs['twitter']->value ?? '' }}"
                                            placeholder="URL o nombre de usuario"
                                            class="pl-10 py-3 focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md">
                                    </div>
                                </div>

                                <!-- Instagram -->
                                <div>
                                    <label for="instagram"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Instagram</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="instagram" name="instagram"
                                            value="{{ $contactConfigs['instagram']->value ?? '' }}"
                                            placeholder="URL o nombre de usuario"
                                            class="pl-10 py-3 focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end mt-8">
                                <button type="submit"
                                    class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-md transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-base font-bold text-gray-800 dark:text-white mb-1">Configuración de Correo</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Gestiona la configuración SMTP para el envío de
                            correos</p>
                    </div>
                    <button id="open-smtp-modal"
                        class="px-1 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 transform hover:scale-105 flex items-center gap-2 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <p class="text-sm">Configurar SMTP</p>
                    </button>
                </div>

                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-md mb-6">
                    <div class="flex items-center gap-2 text-blue-700 dark:text-blue-300 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">Estado de la configuración</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ isset($smtpConfigs['mail_host']->value) && !empty($smtpConfigs['mail_host']->value) ? 'El servidor SMTP está configurado y listo para usar.' : 'La configuración SMTP no está completa. Por favor, configure los parámetros de envío de correo.' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-5">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg transition-all hover:shadow-md">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1 font-medium">
                            Servidor SMTP</p>
                        <p class="text-gray-800 dark:text-white font-medium truncate">
                            {{ $smtpConfigs['mail_host']->value ?? 'No configurado' }}
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg transition-all hover:shadow-md">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1 font-medium">Puerto
                        </p>
                        <p class="text-gray-800 dark:text-white font-medium">
                            {{ $smtpConfigs['mail_port']->value ?? 'No configurado' }}
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg transition-all hover:shadow-md">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1 font-medium">Email
                            remitente</p>
                        <p class="text-gray-800 dark:text-white font-medium truncate">
                            {{ $smtpConfigs['mail_from_address']->value ?? 'No configurado' }}
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg transition-all hover:shadow-md">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1 font-medium">Nombre
                            remitente</p>
                        <p class="text-gray-800 dark:text-white font-medium truncate">
                            {{ $smtpConfigs['mail_from_name']->value ?? 'No configurado' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal SMTP -->
            <div id="smtp-modal"
                class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300">
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto transform transition-all duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Configuración SMTP</h3>
                            <button id="close-smtp-modal"
                                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form id="smtp-form" action="{{ route('configuration.update.smtp') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="col-span-1 md:col-span-2">
                                    <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-md mb-4">
                                        <p class="text-sm text-blue-800 dark:text-blue-300">
                                            Configure correctamente los parámetros del servidor SMTP para garantizar el
                                            envío de correos desde su aplicación.
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <label for="mail_mailer"
                                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Mailer</label>
                                    <input type="text" id="mail_mailer" name="mail_mailer"
                                        value="{{ $smtpConfigs['mail_mailer']->value ?? 'smtp' }}"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2.5 transition-colors duration-300">
                                </div>

                                <div>
                                    <label for="mail_host"
                                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Host
                                        SMTP</label>
                                    <input type="text" id="mail_host" name="mail_host"
                                        value="{{ $smtpConfigs['mail_host']->value ?? '' }}" placeholder="smtp.ejemplo.com"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2.5 transition-colors duration-300">
                                </div>

                                <div>
                                    <label for="mail_port"
                                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Puerto
                                        SMTP</label>
                                    <input type="number" id="mail_port" name="mail_port"
                                        value="{{ $smtpConfigs['mail_port']->value ?? '587' }}" placeholder="587"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2.5 transition-colors duration-300">
                                </div>

                                <div>
                                    <label for="mail_encryption"
                                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Encriptación</label>
                                    <select id="mail_encryption" name="mail_encryption"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2.5 transition-colors duration-300">
                                        <option value="null" {{ ($smtpConfigs['mail_encryption']->value ?? '') == 'null' ? 'selected' : '' }}>Ninguna</option>
                                        <option value="tls" {{ ($smtpConfigs['mail_encryption']->value ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ ($smtpConfigs['mail_encryption']->value ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="mail_username"
                                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Usuario
                                        SMTP</label>
                                    <input type="text" id="mail_username" name="mail_username"
                                        value="{{ $smtpConfigs['mail_username']->value ?? '' }}"
                                        placeholder="usuario@ejemplo.com"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2.5 transition-colors duration-300">
                                </div>

                                <div>
                                    <label for="mail_password"
                                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Contraseña
                                        SMTP</label>
                                    <div class="relative">
                                        <input type="password" id="mail_password" name="mail_password"
                                            value="{{ $smtpConfigs['mail_password']->value ?? '' }}" placeholder="••••••••"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2.5 transition-colors duration-300">
                                        <button type="button" id="toggle-password"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label for="mail_from_address"
                                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Dirección de
                                        Correo Remitente</label>
                                    <input type="email" id="mail_from_address" name="mail_from_address"
                                        value="{{ $smtpConfigs['mail_from_address']->value ?? '' }}"
                                        placeholder="no-reply@ejemplo.com"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2.5 transition-colors duration-300">
                                </div>

                                <div>
                                    <label for="mail_from_name"
                                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Nombre del
                                        Remitente</label>
                                    <input type="text" id="mail_from_name" name="mail_from_name"
                                        value="{{ $smtpConfigs['mail_from_name']->value ?? config('app.name') }}"
                                        placeholder="Mi Aplicación"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2.5 transition-colors duration-300">
                                </div>
                            </div>

                            <div
                                class="flex justify-between items-center pt-5 border-t border-gray-200 dark:border-gray-700">
                                <button type="button" id="test-smtp"
                                    class="px-4 py-2.5 border border-blue-300 text-blue-600 dark:border-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-300 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Probar Conexión
                                </button>

                                <div class="flex gap-3">
                                    <button type="button" id="cancel-smtp"
                                        class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition-colors duration-300">
                                        Cancelar
                                    </button>
                                    <button type="submit"
                                        class="px-5 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 flex items-center gap-2 shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Guardar Configuración
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

@endsection
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Funcionalidad para el modal de SMTP
                    const openSmtpModal = document.getElementById('open-smtp-modal');
                    const closeSmtpModal = document.getElementById('close-smtp-modal');
                    const cancelSmtp = document.getElementById('cancel-smtp');
                    const smtpModal = document.getElementById('smtp-modal');
                    const togglePassword = document.getElementById('toggle-password');
                    const passwordInput = document.getElementById('mail_password');
                    const testSmtpButton = document.getElementById('test-smtp');

                    // Funciones para abrir y cerrar el modal de SMTP con animación
                    if (openSmtpModal) {
                        openSmtpModal.addEventListener('click', function () {
                            smtpModal.classList.remove('hidden');
                            setTimeout(() => {
                                smtpModal.querySelector('.bg-white').classList.add('scale-100');
                                smtpModal.querySelector('.bg-white').classList.remove('scale-95');
                            }, 10);
                        });
                    }

                    function closeModal() {
                        smtpModal.querySelector('.bg-white').classList.add('scale-95');
                        smtpModal.querySelector('.bg-white').classList.remove('scale-100');
                        setTimeout(() => {
                            smtpModal.classList.add('hidden');
                        }, 300);
                    }

                    if (closeSmtpModal) {
                        closeSmtpModal.addEventListener('click', closeModal);
                    }

                    if (cancelSmtp) {
                        cancelSmtp.addEventListener('click', closeModal);
                    }

                    // Cerrar modal si se hace clic fuera del contenido
                    smtpModal.addEventListener('click', function (e) {
                        if (e.target === smtpModal) {
                            closeModal();
                        }
                    });

                    // Mostrar/ocultar contraseña
                    if (togglePassword && passwordInput) {
                        togglePassword.addEventListener('click', function () {
                            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                            passwordInput.setAttribute('type', type);
                            togglePassword.innerHTML = type === 'password'
                                ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>'
                                : '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>';
                        });
                    }

                    // Funcionalidad para probar conexión SMTP
                    if (testSmtpButton) {
                        testSmtpButton.addEventListener('click', function () {
                            // Aquí puedes implementar la lógica para probar la conexión SMTP
                            const formData = new FormData(document.getElementById('smtp-form'));
                            const button = this;
                            const originalText = button.innerHTML;

                            button.disabled = true;
                            button.innerHTML = `
                                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    Probando...
                                                `;

                            // Simular una prueba (reemplaza esto con tu lógica real)
                            setTimeout(() => {
                                alert('La conexión se ha probado con éxito.');
                                button.disabled = false;
                                button.innerHTML = originalText;
                            }, 2000);
                        });
                    }
                });
            </script>
        @endpush
