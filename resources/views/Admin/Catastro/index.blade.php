@extends('layouts.admin')

@section('title', 'Gestión de Catastro')
@section('header', 'Gestión de Catastro')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/catastro/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/catastro/responsive.dataTables.min.css') }}">
    <div class="p-4 dark:bg-gray-900 min-h-screen">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Listado de Registros</h2>
            <button id="openModal"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Agregar
            </button>
        </div>

        <div class="overflow-x-auto">
            <table id="catastroTable" class="min-w-full text-sm border rounded-lg dark:border-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-800 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">N.Expediente</th>
                        <th class="px-4 py-2 text-left">Nombre y Apellido</th>
                        <th class="px-4 py-2 text-left">Cédula</th>
                        <th class="px-4 py-2 text-left">Dirección</th>
                        <th class="px-4 py-2 text-left">Tipo</th>
                        <th class="px-4 py-2 text-left">Descripción</th>
                        <th class="px-4 py-2 text-left">Opciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="dark:text-gray-100">
                        <td class="px-4 py-2">1234</td>
                        <td class="px-4 py-2">Juan Pérez</td>
                        <td class="px-4 py-2">V-12345678</td>
                        <td class="px-4 py-2">Av. Bolívar</td>
                        <td class="px-4 py-2">Residencial</td>
                        <td class="px-4 py-2">Casa de 2 plantas</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button class="text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="dark:text-gray-100">
                        <td class="px-4 py-2">5678</td>
                        <td class="px-4 py-2">Ana Gómez</td>
                        <td class="px-4 py-2">J-98765432</td>
                        <td class="px-4 py-2">Calle Los Pinos</td>
                        <td class="px-4 py-2">Comercial</td>
                        <td class="px-4 py-2">Local para negocio</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button class="text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="dark:text-gray-100">
                        <td class="px-4 py-2">9101</td>
                        <td class="px-4 py-2">Luis Martínez</td>
                        <td class="px-4 py-2">V-11223344</td>
                        <td class="px-4 py-2">Barrio Central</td>
                        <td class="px-4 py-2">Familiar</td>
                        <td class="px-4 py-2">Casa unifamiliar</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button class="text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
            <div class="bg-white dark:bg-gray-800 w-full max-w-md p-6 rounded-2xl shadow-xl">
                <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Agregar nuevo registro</h3>
                <form>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número de
                            expediente:</label>
                        <input type="text"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2" />
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre y
                            apellido:</label>
                        <input type="text"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2" />
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cédula/RIF:</label>
                        <input type="text"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2" />
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección:</label>
                        <input type="text"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2" />
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo:</label>
                        <select
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2">
                            <option value="1">Residencial</option>
                            <option value="2">Comercial</option>
                            <option value="3">Familiar</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción:</label>
                        <textarea
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2"></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" id="closeModal"
                            class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 px-4 py-2 rounded-xl">Cancelar</button>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/catastro/jquery.js') }}"></script>
        <script src="{{ asset('js/catastro/dataTables.min.js') }}"></script>
        <script src="{{ asset('js/catastro/responsive.dataTables.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                let table = $('#catastroTable').DataTable({
                    responsive: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar...",
                        lengthMenu: "Mostrar _MENU_ registros",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        paginate: {
                            first: "Primero",
                            last: "Último",
                            next: "Siguiente",
                            previous: "Anterior"
                        },
                    },
                    initComplete: function() {
                        const searchInput = $('#catastroTable_filter input');
                        searchInput.addClass(
                            'px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white bg-white focus:outline-none focus:ring focus:border-blue-300'
                            );
                        $('#catastroTable_length select').addClass(
                            'px-2 py-1 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white'
                            );
                    }
                });

                // Modificar paginación
                $('#catastroTable_paginate').addClass('mt-4');
                $('#catastroTable_paginate a').addClass(
                    'inline-block px-3 py-1 mx-1 rounded-lg bg-gray-200 dark:bg-gray-700 dark:text-white hover:bg-blue-500 hover:text-white transition-colors'
                    );

                // Mostrar modal
                document.getElementById('openModal').addEventListener('click', () => {
                    document.getElementById('modal').classList.remove('hidden');
                    document.getElementById('modal').classList.add('flex');
                });

                // Ocultar modal
                document.getElementById('closeModal').addEventListener('click', () => {
                    document.getElementById('modal').classList.add('hidden');
                    document.getElementById('modal').classList.remove('flex');
                });
            });
        </script>
    @endpush
@endsection
