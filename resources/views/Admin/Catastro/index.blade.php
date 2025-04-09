@extends('layouts.admin')

@section('title', 'Gestión de Catastro')
@section('header', 'Gestión de Catastro')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/catastro/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/catastro/responsive.dataTables.min.css') }}">
    <div class="p-6 dark:bg-gray-900 min-h-screen">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Listado de Registros</h2>
            <button id="openModal"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow-lg flex items-center gap-2 transition-all duration-300 transform hover:scale-105 focus:ring-4 focus:ring-blue-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Agregar Registro
            </button>
        </div>

        <!-- Card Container -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
            <!-- Filter Controls -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <label for="typeFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filtrar
                        por Tipo</label>
                    <select id="typeFilter"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        <option value="">Todos</option>
                        <option value="Residencial">Residencial</option>
                        <option value="Comercial">Comercial</option>
                        <option value="Familiar">Familiar</option>
                    </select>
                </div>

                <div class="relative">
                    <label for="statusFilter"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estatus</label>
                    <select id="statusFilter"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        <option value="">Todos</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                        <option value="Pendiente">Pendiente</option>
                    </select>
                </div>

                <div class="relative">
                    <label for="customSearch"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="customSearch"
                            class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Buscar registros...">
                    </div>
                </div>
            </div>

            <!-- DataTable Container with shadow and rounded corners -->
            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="relative overflow-x-auto">
                    <table id="catastroTable" class="w-full text-sm text-left rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-4">N.Expediente</th>
                                <th class="px-6 py-4">Nombre y Apellido</th>
                                <th class="px-6 py-4">Cédula</th>
                                <th class="px-6 py-4">Dirección</th>
                                <th class="px-6 py-4">Tipo</th>
                                <th class="px-6 py-4">Descripción</th>
                                <th class="px-6 py-4">Estado</th>
                                <th class="px-6 py-4 text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catastros as $catastro)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 font-medium">{{ $catastro->num_expe }}</td>
                                    <td class="px-6 py-4">{{ $catastro->nom_ape }}</td>
                                    <td class="px-6 py-4">{{ $catastro->ced }}</td>
                                    <td class="px-6 py-4">{{ $catastro->direccion }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-amber-900 dark:text-amber-300">{{ $catastro->tipo }}</span>
                                    </td>
                                    <td class="px-6 py-4">{{ $catastro->descripcion }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">{{ $catastro->estado }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <button
                                                class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 p-2 rounded-lg transition-colors dark:bg-blue-900 dark:hover:bg-blue-800 dark:text-blue-300"
                                                title="Ver detalles">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button
                                                class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 hover:bg-yellow-200 p-2 rounded-lg transition-colors dark:bg-yellow-900 dark:hover:bg-yellow-800 dark:text-yellow-300"
                                                title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button
                                                class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-2 rounded-lg transition-colors dark:bg-red-900 dark:hover:bg-red-800 dark:text-red-300"
                                                title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal for Adding/Editing Records -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
            <div class="bg-white dark:bg-gray-800 w-full max-w-md p-6 rounded-2xl shadow-xl animate-scale-up">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Agregar nuevo registro</h3>
                    <button id="closeModalX"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-1">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número de
                                expediente:</label>
                            <input type="text"
                                class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div class="mb-3">
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cédula/RIF:</label>
                            <input type="text"
                                class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre y
                            apellido:</label>
                        <input type="text"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dirección:</label>
                        <input type="text"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo:</label>
                            <select
                                class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="1">Residencial</option>
                                <option value="2">Comercial</option>
                                <option value="3">Familiar</option>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado:</label>
                            <select
                                class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="1">Activo</option>
                                <option value="2">Pendiente</option>
                                <option value="3">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción:</label>
                        <input type="text"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" id="closeModal"
                            class="px-4 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 rounded-lg transition-colors font-medium">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium flex items-center gap-2 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Guardar
                        </button>
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
            $(document).ready(function () {
                // Inicializar DataTable
                let table = $('#catastroTable').DataTable({
                    responsive: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar...",
                        lengthMenu: "Mostrar _MENU_ registros",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        infoEmpty: "Mostrando 0 a 0 de 0 registros",
                        infoFiltered: "(filtrado de _MAX_ registros en total)",
                        zeroRecords: "No se encontraron registros coincidentes",
                        emptyTable: "No hay datos disponibles en la tabla",
                        paginate: {
                            first: "Primero",
                            last: "Último",
                            next: "Siguiente",
                            previous: "Anterior"
                        },
                    },
                    dom: '<"flex flex-col md:flex-row justify-between items-start md:items-center mb-3"<"flex-1"l><"mb-2 md:mb-0"f>><"overflow-x-auto"t><"flex flex-col md:flex-row justify-between items-center mt-4"<"text-sm text-gray-700 dark:text-gray-300"i><"flex-1 flex justify-end"p>>',
                    initComplete: function () {
                        // Personalizar el campo de búsqueda
                        const searchInput = $('.dataTables_filter input');
                        searchInput.addClass(
                            'px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-auto'
                        );
                        $('.dataTables_filter').addClass('w-full md:w-auto');

                        // Personalizar selector de registros por página
                        $('.dataTables_length select').addClass(
                            'px-3 py-2 ml-1 mr-1 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
                        );

                        // Conectar búsqueda personalizada a DataTables
                        $('#customSearch').on('keyup', function () {
                            table.search(this.value).draw();
                        });

                        // Filtros de columnas
                        $('#typeFilter').on('change', function () {
                            table.column(4).search(this.value).draw();
                        });

                        $('#statusFilter').on('change', function () {
                            table.column(6).search(this.value).draw();
                        });

                        // Aplicar clases a la paginación
                        stylePagination();
                    },
                    drawCallback: function () {
                        stylePagination();
                    }
                });

                // Función para aplicar estilos a la paginación
                function stylePagination() {
                    // Añadir clases a los botones de paginación
                    $('.dataTables_paginate .paginate_button').addClass(
                        'px-3 py-1 mx-1 rounded-lg text-sm font-medium transition-colors'
                    );

                    $('.dataTables_paginate .paginate_button:not(.current)').addClass(
                        'bg-gray-100 text-gray-700 hover:bg-blue-500 hover:text-white dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-blue-600'
                    );

                    $('.dataTables_paginate .paginate_button.current').addClass(
                        'bg-blue-500 text-white dark:bg-blue-600'
                    );

                    $('.dataTables_paginate .paginate_button.disabled').addClass(
                        'bg-gray-100 text-gray-400 cursor-not-allowed hover:bg-gray-100 hover:text-gray-400 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-800'
                    );

                    // Mejorar estilo del contenedor de paginación
                    $('.dataTables_paginate').addClass('flex items-center justify-center md:justify-end');
                }

                // Animación para los botones
                $('.dataTables_wrapper').on('mouseenter', '.paginate_button:not(.disabled)', function () {
                    $(this).addClass('transform scale-105 transition-transform');
                }).on('mouseleave', '.paginate_button:not(.disabled)', function () {
                    $(this).removeClass('transform scale-105 transition-transform');
                });

                // Gestión del modal
                document.getElementById('openModal').addEventListener('click', () => {
                    document.getElementById('modal').classList.remove('hidden');
                    document.getElementById('modal').classList.add('flex');
                    setTimeout(() => {
                        document.querySelector('#modal > div').classList.add('scale-100');
                        document.querySelector('#modal > div').classList.remove('scale-95');
                    }, 10);
                });

                // Múltiples formas de cerrar el modal
                const closeModal = () => {
                    document.querySelector('#modal > div').classList.add('scale-95');
                    document.querySelector('#modal > div').classList.remove('scale-100');
                    setTimeout(() => {
                        document.getElementById('modal').classList.add('hidden');
                        document.getElementById('modal').classList.remove('flex');
                    }, 300);
                };

                document.getElementById('closeModal').addEventListener('click', closeModal);
                document.getElementById('closeModalX').addEventListener('click', closeModal);

                // Cerrar modal haciendo clic fuera
                document.getElementById('modal').addEventListener('click', (e) => {
                    if (e.target.id === 'modal') closeModal();
                });

                // Aplicar efectos de hover a las filas de la tabla
                $('#catastroTable tbody').on('mouseenter', 'tr', function () {
                    $(this).addClass('shadow-md');
                }).on('mouseleave', 'tr', function () {
                    $(this).removeClass('shadow-md');
                });

                // Tooltips mejorados para los botones de acción
                $('#catastroTable').on('mouseenter', 'button[title]', function () {
                    const title = $(this).attr('title');
                    const tooltip = $(
                        '<div class="tooltip bg-gray-900 text-white text-xs rounded py-1 px-2 absolute z-10"></div>'
                    );
                    tooltip.text(title);
                    $('body').append(tooltip);

                    const btnPos = $(this).offset();
                    const btnWidth = $(this).outerWidth();
                    const btnHeight = $(this).outerHeight();

                    tooltip.css({
                        top: btnPos.top - tooltip.outerHeight() - 5,
                        left: btnPos.left + (btnWidth - tooltip.outerWidth()) / 2
                    });

                    $(this).data('tooltip', tooltip);
                }).on('mouseleave', 'button[title]', function () {
                    $(this).data('tooltip').remove();
                });

                // Añadir efecto al filtrar
                const originalRowBackground = $('#catastroTable tbody tr').css('background-color');
                $('#typeFilter, #statusFilter, #customSearch').on('change keyup', function () {
                    if ($(this).val() !== '') {
                        $('#catastroTable').addClass('filtered');
                    } else {
                        if ($('#typeFilter').val() === '' && $('#statusFilter').val() === '' && $(
                            '#customSearch').val() === '') {
                            $('#catastroTable').removeClass('filtered');
                        }
                    }
                });

                // Añadir animaciones CSS
                const style = document.createElement('style');
                style.innerHTML = `
                                    .animate-scale-up {
                                        transform: scale(0.95);
                                        opacity: 0;
                                        animation: scaleUp 0.3s ease forwards;
                                    }

                                    @keyframes scaleUp {
                                        to {
                                            transform: scale(1);
                                            opacity: 1;
                                        }
                                    }

                                    #modal > div {
                                        transition: transform 0.3s ease, opacity 0.3s ease;
                                        transform: scale(0.95);
                                    }

                                    #modal > div.scale-100 {
                                        transform: scale(1);
                                    }

                                    .filtered tbody tr:not(.shown) {
                                        background-color: rgba(59, 130, 246, 0.05);
                                    }

                                    .tooltip {
                                        pointer-events: none;
                                        opacity: 0;
                                        transition: opacity 0.2s;
                                        animation: fadeIn 0.2s ease forwards;
                                    }

                                    @keyframes fadeIn {
                                        to {
                                            opacity: 1;
                                        }
                                    }
                                `;
                document.head.appendChild(style);
            });
        </script>
    @endpush
@endsection