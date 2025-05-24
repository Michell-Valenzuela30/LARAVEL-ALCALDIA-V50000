@extends('layouts.admin')

@section('title', 'Gestión de Catastro')
@section('header', 'Gestión de Catastro')

@section('content')
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold dark:text-white">Cédulas Catastrales</h2>
            <button id="btn-nueva-cedula"
                class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-plus mr-2"></i> Nueva Cédula
            </button>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg">
            <table id="tabla-cedulas" class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                <thead
                    class="text-xs font-semibold uppercase bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-hashtag text-blue-500"></i>
                                <span>N° Cédula</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-folder-open text-green-500"></i>
                                <span>N° Expediente</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-user text-purple-500"></i>
                                <span>Propietario</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-home text-orange-500"></i>
                                <span>Tipo Inmueble</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-map-marker-alt text-red-500"></i>
                                <span>Ámbito</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar text-yellow-500"></i>
                                <span>Fecha Expedición</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-cogs text-gray-500"></i>
                                <span>Acciones</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Los datos se cargarán dinámicamente con DataTables -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para crear/editar cédula catastral -->
    <div id="modal-cedula" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="modal-title" class="text-xl font-semibold dark:text-white">Nueva Cédula Catastral</h3>
                    <button id="close-modal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form id="form-cedula-catastral">
                    <input type="hidden" id="cedula-id" name="id">

                    <!-- Progress Steps -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="step-circle active" data-step="1">1</div>
                                <div class="step-line"></div>
                                <div class="step-circle" data-step="2">2</div>
                                <div class="step-line"></div>
                                <div class="step-circle" data-step="3">3</div>
                                <div class="step-line"></div>
                                <div class="step-circle" data-step="4">4</div>
                            </div>
                        </div>
                        <div class="flex justify-between mt-2 text-sm">
                            <span class="step-label active">Propietario</span>
                            <span class="step-label">Datos Principales</span>
                            <span class="step-label">Linderos</span>
                            <span class="step-label">Documentos</span>
                        </div>
                    </div>

                    <!-- Step 1: Propietario -->
                    <div class="step-content active" data-step="1">
                        <h4 class="text-lg font-medium mb-4 pb-2 border-b dark:border-gray-700">Seleccionar Propietario</h4>

                        <div class="mb-4">
                            <label for="propietario_select" class="block mb-2 text-sm font-medium">Propietario</label>
                            <div class="flex space-x-2">
                                <select id="propietario_select" name="propietario_id"
                                    class="flex-1 p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Seleccione un propietario</option>
                                </select>
                                <button type="button" id="btn-nuevo-propietario"
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                                    <i class="fas fa-plus"></i> Nuevo
                                </button>
                            </div>
                            <div class="text-red-500 text-xs mt-1 error-propietario_id"></div>
                        </div>

                        <!-- Información del propietario seleccionado -->
                        <div id="info-propietario" class="hidden bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                            <h5 class="font-medium mb-2">Información del Propietario:</h5>
                            <p><strong>Nombre:</strong> <span id="prop-nombre"></span></p>
                            <p><strong>Cédula:</strong> <span id="prop-cedula"></span></p>
                        </div>
                    </div>

                    <!-- Step 2: Datos Principales -->
                    <div class="step-content" data-step="2">
                        <h4 class="text-lg font-medium mb-4 pb-2 border-b dark:border-gray-700">Datos Principales</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="numero_cedula" class="block mb-2 text-sm font-medium">Cédula Catastral</label>
                                <input type="text" id="numero_cedula" name="numero_cedula"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                <div class="text-red-500 text-xs mt-1 error-numero_cedula"></div>
                            </div>

                            <div>
                                <label for="numero_expediente" class="block mb-2 text-sm font-medium">Número de
                                    Expediente</label>
                                <input type="text" id="numero_expediente" name="numero_expediente"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                <div class="text-red-500 text-xs mt-1 error-numero_expediente"></div>
                            </div>

                            <div class="md:col-span-2">
                                <label for="direccion_inmueble" class="block mb-2 text-sm font-medium">Dirección del
                                    Inmueble</label>
                                <textarea id="direccion_inmueble" name="direccion_inmueble" rows="3"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600"></textarea>
                                <div class="text-red-500 text-xs mt-1 error-direccion_inmueble"></div>
                            </div>

                            <div>
                                <label for="tipo_inmueble" class="block mb-2 text-sm font-medium">Tipo de Inmueble</label>
                                <select id="tipo_inmueble" name="tipo_inmueble"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Seleccione</option>
                                    <option value="Terreno">Terreno</option>
                                    <option value="Casa">Casa</option>
                                    <option value="Local">Local</option>
                                    <option value="Galpon">Galpón</option>
                                </select>
                                <div class="text-red-500 text-xs mt-1 error-tipo_inmueble"></div>
                            </div>

                            <div>
                                <label for="ambito" class="block mb-2 text-sm font-medium">Ámbito</label>
                                <select id="ambito" name="ambito"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Seleccione</option>
                                    <option value="Urbano">Urbano</option>
                                    <option value="Rural">Rural</option>
                                </select>
                                <div class="text-red-500 text-xs mt-1 error-ambito"></div>
                            </div>

                            <div>
                                <label for="avaluo_total" class="block mb-2 text-sm font-medium">Avalúo Total
                                    (Bs.)</label>
                                <input type="number" step="0.01" id="avaluo_total" name="avaluo_total"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="fecha_expedicion" class="block mb-2 text-sm font-medium">Fecha de
                                    Expedición</label>
                                <input type="date" id="fecha_expedicion" name="fecha_expedicion"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                <div class="text-red-500 text-xs mt-1 error-fecha_expedicion"></div>
                            </div>

                            <div>
                                <label for="vigencia_trimestre" class="block mb-2 text-sm font-medium">Vigencia
                                    (Trimestre)</label>
                                <select id="vigencia_trimestre" name="vigencia_trimestre"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Seleccione</option>
                                    <option value="PRIMER">PRIMER</option>
                                    <option value="SEGUNDO">SEGUNDO</option>
                                    <option value="TERCER">TERCER</option>
                                    <option value="CUARTO">CUARTO</option>
                                </select>
                                <div class="text-red-500 text-xs mt-1 error-vigencia_trimestre"></div>
                            </div>

                            <div>
                                <label for="solicitado_para" class="block mb-2 text-sm font-medium">Solicitado
                                    Para</label>
                                <input type="text" id="solicitado_para" name="solicitado_para"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Linderos -->
                    <div class="step-content" data-step="3">
                        <h4 class="text-lg font-medium mb-4 pb-2 border-b dark:border-gray-700">Linderos</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="norte" class="block mb-2 text-sm font-medium">Norte</label>
                                <input type="text" id="norte" name="norte"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="mt2_norte" class="block mb-2 text-sm font-medium">Metros (Norte)</label>
                                <input type="number" step="0.01" id="mt2_norte" name="mt2_norte"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="sur" class="block mb-2 text-sm font-medium">Sur</label>
                                <input type="text" id="sur" name="sur"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="mt2_sur" class="block mb-2 text-sm font-medium">Metros (Sur)</label>
                                <input type="number" step="0.01" id="mt2_sur" name="mt2_sur"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="este" class="block mb-2 text-sm font-medium">Este</label>
                                <input type="text" id="este" name="este"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="mt2_este" class="block mb-2 text-sm font-medium">Metros (Este)</label>
                                <input type="number" step="0.01" id="mt2_este" name="mt2_este"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="oeste" class="block mb-2 text-sm font-medium">Oeste</label>
                                <input type="text" id="oeste" name="oeste"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="mt2_oeste" class="block mb-2 text-sm font-medium">Metros (Oeste)</label>
                                <input type="number" step="0.01" id="mt2_oeste" name="mt2_oeste"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div class="md:col-span-2">
                                <label for="mt2_total" class="block mb-2 text-sm font-medium">Metros Totales</label>
                                <input type="number" step="0.01" id="mt2_total" name="mt2_total"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Documentos Legales -->
                    <div class="step-content" data-step="4">
                        <h4 class="text-lg font-medium mb-4 pb-2 border-b dark:border-gray-700">Documentos Legales</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tipo_documento" class="block mb-2 text-sm font-medium">Tipo de
                                    Documento</label>
                                <select id="tipo_documento" name="tipo_documento"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Seleccione</option>
                                    <option value="Registrado">Registrado</option>
                                    <option value="Notariado">Notariado</option>
                                    <option value="Juzgado">Juzgado</option>
                                </select>
                            </div>

                            <div>
                                <label for="numero_documento" class="block mb-2 text-sm font-medium">Número de
                                    Documento</label>
                                <input type="text" id="numero_documento" name="numero_documento"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="matricula" class="block mb-2 text-sm font-medium">Matrícula</label>
                                <input type="text" id="matricula" name="matricula"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="folio" class="block mb-2 text-sm font-medium">Folio</label>
                                <input type="text" id="folio" name="folio"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div>
                                <label for="fecha_documento" class="block mb-2 text-sm font-medium">Fecha del
                                    Documento</label>
                                <input type="date" id="fecha_documento" name="fecha_documento"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div class="md:col-span-2">
                                <label for="descripcion_documento"
                                    class="block mb-2 text-sm font-medium">Descripción</label>
                                <textarea id="descripcion_documento" name="descripcion_documento" rows="2"
                                    class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation buttons -->
                    <div class="flex justify-between mt-8">
                        <button type="button" id="btn-anterior"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md hidden">Anterior</button>
                        <div class="flex space-x-4">
                            <button type="button" id="cancelar-cedula"
                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md">Cancelar</button>
                            <button type="button" id="btn-siguiente"
                                class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-md">Siguiente</button>
                            <button type="submit" id="guardar-cedula"
                                class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-md hidden">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal de confirmación de eliminación -->
    <div id="modal-eliminar" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-4 dark:text-white">Confirmar eliminación</h3>
                <p class="mb-6 dark:text-gray-300">¿Estás seguro de que deseas eliminar esta cédula catastral? Esta acción
                    no se puede deshacer.</p>
                <input type="hidden" id="eliminar-id">
                <div class="flex justify-end space-x-4">
                    <button id="cancelar-eliminar"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md">Cancelar</button>
                    <button id="confirmar-eliminar"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para crear nuevo propietario -->
    <div id="modal-nuevo-propietario"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold dark:text-white">Nuevo Propietario</h3>
                    <button id="close-modal-propietario"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form id="form-nuevo-propietario">
                    <div class="space-y-4">
                        <div>
                            <label for="prop_nombre_apellido" class="block mb-2 text-sm font-medium">Nombre y
                                Apellido</label>
                            <input type="text" id="prop_nombre_apellido" name="nombre_apellido" required
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            <div class="text-red-500 text-xs mt-1 error-nombre_apellido"></div>
                        </div>

                        <div>
                            <label for="prop_cedula" class="block mb-2 text-sm font-medium">Cédula</label>
                            <input type="text" id="prop_cedula" name="cedula" required
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            <div class="text-red-500 text-xs mt-1 error-cedula"></div>
                        </div>

                        <div>
                            <label for="prop_rif" class="block mb-2 text-sm font-medium">RIF (Opcional)</label>
                            <input type="text" id="prop_rif" name="rif"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            <div class="text-red-500 text-xs mt-1 error-rif"></div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" id="cancelar-propietario"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                            Guardar Propietario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            .step-circle {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                background-color: #e5e7eb;
                color: #6b7280;
                transition: all 0.3s ease;
            }

            .step-circle.active {
                background-color: #3b82f6;
                color: white;
            }

            .step-circle.completed {
                background-color: #10b981;
                color: white;
            }

            .step-line {
                flex: 1;
                height: 2px;
                background-color: #e5e7eb;
                margin: 0 10px;
                transition: all 0.3s ease;
            }

            .step-line.active {
                background-color: #3b82f6;
            }

            .step-label {
                font-size: 0.875rem;
                color: #6b7280;
                transition: all 0.3s ease;
            }

            .step-label.active {
                color: #3b82f6;
                font-weight: 600;
            }

            .step-content {
                display: none;
            }

            .step-content.active {
                display: block;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('js/catastro/jquery.js') }}"></script>
        <script src="{{ asset('js/catastro/dataTables.min.js') }}"></script>
        <script src="{{ asset('js/catastro/responsive.dataTables.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                let currentStep = 1;
                const totalSteps = 4;

                // Configuración de DataTables
                const tabla = $('#tabla-cedulas').DataTable({
                    responsive: true,
                    processing: true,
                    pageLength: 10,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, "Todos"]
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                    },
                    dom: '<"flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0"<"flex items-center"l><"flex items-center space-x-2"f>>rtip',
                    initComplete: function() {
                        // Aplicar estilos a los controles de DataTables
                        $('.dataTables_length select').addClass(
                            'px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent'
                        );
                        $('.dataTables_filter input').addClass(
                            'px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent'
                        );
                        $('.dataTables_paginate .paginate_button').addClass(
                            'px-3 py-2 mx-1 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-300'
                        );
                        $('.dataTables_paginate .paginate_button.current').addClass(
                            '!bg-blue-600 !text-white !border-blue-600');
                    },
                    ajax: {
                        url: "{{ route('cedulas.data') }}",
                        type: 'GET',
                        dataSrc: 'data',
                        error: function(xhr, error, thrown) {
                            console.error('Error en la carga de datos:', error, thrown);
                            console.log('Respuesta del servidor:', xhr.responseText);
                        }
                    },
                    columns: [{
                            data: 'numero_cedula',
                            className: 'px-6 py-4 font-medium text-gray-900 dark:text-gray-100'
                        },
                        {
                            data: 'numero_expediente',
                            className: 'px-6 py-4 text-gray-700 dark:text-gray-300'
                        },
                        {
                            data: 'propietario.nombre_apellido',
                            defaultContent: 'N/A',
                            className: 'px-6 py-4 text-gray-700 dark:text-gray-300',
                            render: function(data, type, row) {
                                return row.propietario ?
                                    `<div class="flex flex-col">
                    <span class="font-medium">${row.propietario.nombre_apellido}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">${row.propietario.cedula}</span>
                </div>` : 'N/A';
                            }
                        },
                        {
                            data: 'tipo_inmueble',
                            className: 'px-6 py-4',
                            render: function(data) {
                                const colores = {
                                    'Terreno': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'Casa': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'Local': 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                                    'Galpon': 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300'
                                };
                                return `<span class="px-2 py-1 text-xs font-semibold rounded-full ${colores[data] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'}">${data}</span>`;
                            }
                        },
                        {
                            data: 'ambito',
                            className: 'px-6 py-4',
                            render: function(data) {
                                const color = data === 'Urbano' ?
                                    'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' :
                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                                return `<span class="px-2 py-1 text-xs font-semibold rounded-full ${color}">${data}</span>`;
                            }
                        },
                        {
                            data: 'fecha_expedicion',
                            className: 'px-6 py-4 text-gray-700 dark:text-gray-300',
                            render: function(data) {
                                return new Date(data).toLocaleDateString('es-ES', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric'
                                });
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            className: 'px-6 py-4',
                            render: function(data) {
                                return `
                            <div class="flex items-center space-x-2">
                                <button class="btn-editar inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md" data-id="${data.id}" title="Editar">
                                    <i class="fas fa-edit w-3 h-3"></i>
                                </button>
                                <button class="btn-renovar inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md" data-id="${data.id}" title="Renovar">
                                    <i class="fas fa-sync-alt w-3 h-3"></i>
                                </button>
                                <button class="btn-historial inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-purple-600 hover:bg-purple-700 dark:bg-purple-500 dark:hover:bg-purple-600 rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md" data-numero="${data.numero_cedula}" title="Ver Historial">
                                    <i class="fas fa-history w-3 h-3"></i>
                                </button>
                                <button class="btn-eliminar inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md" data-id="${data.id}" title="Eliminar">
                                    <i class="fas fa-trash-alt w-3 h-3"></i>
                                </button>
                            </div>
                        `;
                            }
                        }
                    ]
                });

                // Cargar propietarios al abrir el modal
                function cargarPropietarios() {
                    $.ajax({
                        url: "{{ route('propietarios.get') }}",
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                $('#propietario_select').empty().append(
                                    '<option value="">Seleccione un propietario</option>');
                                response.propietarios.forEach(function(propietario) {
                                    $('#propietario_select').append(
                                        `<option value="${propietario.id}" data-nombre="${propietario.nombre_apellido}" data-cedula="${propietario.cedula}">
                                ${propietario.nombre_apellido} - ${propietario.cedula}
                            </option>`
                                    );
                                });
                            }
                        },
                        error: function() {
                            console.error('Error al cargar propietarios');
                        }
                    });
                }

                // Función para mostrar información del propietario seleccionado
                $('#propietario_select').change(function() {
                    const selectedOption = $(this).find('option:selected');
                    if (selectedOption.val()) {
                        $('#prop-nombre').text(selectedOption.data('nombre'));
                        $('#prop-cedula').text(selectedOption.data('cedula'));
                        $('#info-propietario').removeClass('hidden');
                    } else {
                        $('#info-propietario').addClass('hidden');
                    }
                });

                // Funciones de navegación por pasos
                function showStep(step) {
                    // Ocultar todos los pasos
                    $('.step-content').removeClass('active');
                    $('.step-circle').removeClass('active completed');
                    $('.step-label').removeClass('active');
                    $('.step-line').removeClass('active');

                    // Mostrar el paso actual
                    $(`.step-content[data-step="${step}"]`).addClass('active');
                    $(`.step-circle[data-step="${step}"]`).addClass('active');
                    $(`.step-label`).eq(step - 1).addClass('active');

                    // Marcar pasos completados
                    for (let i = 1; i < step; i++) {
                        $(`.step-circle[data-step="${i}"]`).addClass('completed');
                        if (i < step - 1) {
                            $('.step-line').eq(i - 1).addClass('active');
                        }
                    }

                    // Controlar botones de navegación
                    if (step === 1) {
                        $('#btn-anterior').addClass('hidden');
                    } else {
                        $('#btn-anterior').removeClass('hidden');
                    }

                    if (step === totalSteps) {
                        $('#btn-siguiente').addClass('hidden');
                        $('#guardar-cedula').removeClass('hidden');
                    } else {
                        $('#btn-siguiente').removeClass('hidden');
                        $('#guardar-cedula').addClass('hidden');
                    }

                    currentStep = step;
                }

                // Navegación: Siguiente
                $('#btn-siguiente').click(function() {
                    if (validateCurrentStep()) {
                        if (currentStep < totalSteps) {
                            showStep(currentStep + 1);
                        }
                    }
                });

                // Navegación: Anterior
                $('#btn-anterior').click(function() {
                    if (currentStep > 1) {
                        showStep(currentStep - 1);
                    }
                });

                // Validación básica por paso
                function validateCurrentStep() {
                    let isValid = true;
                    $('.text-red-500').empty();

                    switch (currentStep) {
                        case 1: // Propietario
                            if (!$('#propietario_select').val()) {
                                $('.error-propietario_id').text('Debe seleccionar un propietario');
                                isValid = false;
                            }
                            break;
                        case 2: // Datos principales
                            if (!$('#numero_cedula').val()) {
                                $('.error-numero_cedula').text('El número de cédula es obligatorio');
                                isValid = false;
                            }
                            if (!$('#numero_expediente').val()) {
                                $('.error-numero_expediente').text('El número de expediente es obligatorio');
                                isValid = false;
                            }
                            if (!$('#direccion_inmueble').val()) {
                                $('.error-direccion_inmueble').text('La dirección del inmueble es obligatoria');
                                isValid = false;
                            }
                            if (!$('#tipo_inmueble').val()) {
                                $('.error-tipo_inmueble').text('Debe seleccionar el tipo de inmueble');
                                isValid = false;
                            }
                            if (!$('#ambito').val()) {
                                $('.error-ambito').text('Debe seleccionar el ámbito');
                                isValid = false;
                            }
                            if (!$('#fecha_expedicion').val()) {
                                $('.error-fecha_expedicion').text('La fecha de expedición es obligatoria');
                                isValid = false;
                            }
                            if (!$('#vigencia_trimestre').val()) {
                                $('.error-vigencia_trimestre').text('Debe seleccionar el trimestre de vigencia');
                                isValid = false;
                            }
                            break;
                        case 3: // Linderos - validación opcional
                            // Los linderos son opcionales, pero si se llenan algunos campos, validar coherencia
                            break;
                        case 4: // Documentos - validación opcional
                            // Los documentos son opcionales
                            break;
                    }

                    return isValid;
                }

                // Modal de Nueva Cédula
                $('#btn-nueva-cedula').click(function() {
                    resetearFormulario();
                    cargarPropietarios();
                    showStep(1);
                    $('#modal-title').text('Nueva Cédula Catastral');
                    $('#modal-cedula').removeClass('hidden');
                });

                // Cerrar modales
                $('#close-modal, #cancelar-cedula').click(function() {
                    $('#modal-cedula').addClass('hidden');
                });

                $('#close-modal-propietario, #cancelar-propietario').click(function() {
                    $('#modal-nuevo-propietario').addClass('hidden');
                });

                // Nuevo propietario
                $('#btn-nuevo-propietario').click(function() {
                    resetearFormularioPropietario();
                    $('#modal-nuevo-propietario').removeClass('hidden');
                });

                // Guardar nuevo propietario
                $('#form-nuevo-propietario').submit(function(e) {
                    e.preventDefault();
                    $('.text-red-500').empty();

                    const formData = $(this).serialize();

                    $.ajax({
                        url: "{{ route('propietarios.store') }}",
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#modal-nuevo-propietario').addClass('hidden');

                                // Agregar el nuevo propietario al select
                                $('#propietario_select').append(
                                    `<option value="${response.propietario.id}" data-nombre="${response.propietario.nombre_apellido}" data-cedula="${response.propietario.cedula}">
                            ${response.propietario.nombre_apellido} - ${response.propietario.cedula}
                        </option>`
                                );

                                // Seleccionar el nuevo propietario
                                $('#propietario_select').val(response.propietario.id).trigger(
                                    'change');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            console.log('Error response:', xhr.responseJSON); // Para depuración
                            const response = xhr.responseJSON;

                            if (response && response.errors) {
                                // Mostrar errores de validación
                                Object.keys(response.errors).forEach(function(key) {
                                    $(`.error-${key}`).text(response.errors[key][0]);
                                });

                                // Si hay errores en el paso 1 o 2, volver a ese paso
                                if (response.errors.propietario_id) {
                                    showStep(1);
                                } else if (response.errors.numero_cedula || response.errors
                                    .numero_expediente ||
                                    response.errors.direccion_inmueble || response.errors
                                    .tipo_inmueble ||
                                    response.errors.ambito || response.errors.fecha_expedicion ||
                                    response.errors.vigencia_trimestre) {
                                    showStep(2);
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response && response.message ? response.message :
                                        'Error al guardar la cédula catastral'
                                });
                            }
                        }
                    });
                });

                // Editar cédula
                $(document).on('click', '.btn-editar', function() {
                    const id = $(this).data('id');

                    $.ajax({
                        url: `/cedulas/${id}`,
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                cargarPropietarios();
                                setTimeout(() => {
                                    cargarDatosFormulario(response.cedula);
                                    showStep(1);
                                    $('#modal-title').text('Editar Cédula Catastral');
                                    $('#modal-cedula').removeClass('hidden');
                                }, 500);
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo cargar la información de la cédula'
                            });
                        }
                    });
                });

                // Renovar cédula
                $(document).on('click', '.btn-renovar', function() {
                    const id = $(this).data('id');

                    Swal.fire({
                        title: '¿Renovar cédula catastral?',
                        text: 'Se creará una nueva cédula para el siguiente trimestre',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, renovar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/cedulas/${id}/renovar`,
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.success) {
                                        tabla.ajax.reload();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Éxito',
                                            text: response.message
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    const response = xhr.responseJSON;
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response && response.message ?
                                            response.message :
                                            'Error al renovar la cédula'
                                    });
                                }
                            });
                        }
                    });
                });

                // Eliminar cédula
                $(document).on('click', '.btn-eliminar', function() {
                    const id = $(this).data('id');
                    $('#eliminar-id').val(id);
                    $('#modal-eliminar').removeClass('hidden');
                });

                // Cancelar eliminación
                $('#cancelar-eliminar').click(function() {
                    $('#modal-eliminar').addClass('hidden');
                });

                // Confirmar eliminación
                $('#confirmar-eliminar').click(function() {
                    const id = $('#eliminar-id').val();

                    $.ajax({
                        url: `/cedulas/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#modal-eliminar').addClass('hidden');
                                tabla.ajax.reload();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response && response.message ? response.message :
                                    'Error al eliminar la cédula catastral'
                            });
                        }
                    });
                });

                // Guardar cédula
                $('#form-cedula-catastral').submit(function(e) {
                    e.preventDefault();

                    // Limpiar mensajes de error anteriores
                    $('.text-red-500').empty();

                    const formData = $(this).serialize();
                    console.log('Datos del formulario:', formData); // Para depuración

                    $.ajax({
                        url: "{{ route('cedulas.store') }}",
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#modal-cedula').addClass('hidden');
                                tabla.ajax.reload();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;

                            if (response && response.errors) {
                                // Mostrar errores de validación
                                Object.keys(response.errors).forEach(function(key) {
                                    $(`.error-${key}`).text(response.errors[key][0]);
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error al guardar la cédula catastral'
                                });
                            }
                        }
                    });
                });

                // Función para resetear el formulario
                function resetearFormulario() {
                    $('#form-cedula-catastral')[0].reset();
                    $('#cedula-id').val('');
                    $('.text-red-500').empty();
                    $('#info-propietario').addClass('hidden');
                }

                // Función para resetear el formulario de propietario
                function resetearFormularioPropietario() {
                    $('#form-nuevo-propietario')[0].reset();
                    $('.text-red-500').empty();
                }

                // Función para cargar datos en el formulario
                function cargarDatosFormulario(cedula) {
                    // Reset previo
                    resetearFormulario();

                    // Datos de la cédula
                    $('#cedula-id').val(cedula.id);
                    $('#numero_cedula').val(cedula.numero_cedula);
                    $('#numero_expediente').val(cedula.numero_expediente);
                    $('#direccion_inmueble').val(cedula.direccion_inmueble);
                    $('#tipo_inmueble').val(cedula.tipo_inmueble);
                    $('#ambito').val(cedula.ambito);
                    $('#avaluo_total').val(cedula.avaluo_total);
                    $('#fecha_expedicion').val(cedula.fecha_expedicion);
                    $('#vigencia_trimestre').val(cedula.vigencia_trimestre);
                    $('#solicitado_para').val(cedula.solicitado_para);

                    // Seleccionar propietario
                    if (cedula.propietario) {
                        $('#propietario_select').val(cedula.propietario_id).trigger('change');
                    }

                    // Datos de linderos
                    if (cedula.linderos) {
                        $('#norte').val(cedula.linderos.norte);
                        $('#sur').val(cedula.linderos.sur);
                        $('#este').val(cedula.linderos.este);
                        $('#oeste').val(cedula.linderos.oeste);
                        $('#mt2_norte').val(cedula.linderos.mt2_norte);
                        $('#mt2_sur').val(cedula.linderos.mt2_sur);
                        $('#mt2_este').val(cedula.linderos.mt2_este);
                        $('#mt2_oeste').val(cedula.linderos.mt2_oeste);
                        $('#mt2_total').val(cedula.linderos.mt2_total);
                    }

                    // Datos del documento legal
                    if (cedula.documentoLegal) {
                        $('#tipo_documento').val(cedula.documentoLegal.tipo);
                        $('#numero_documento').val(cedula.documentoLegal.numero);
                        $('#matricula').val(cedula.documentoLegal.matricula);
                        $('#folio').val(cedula.documentoLegal.folio);
                        $('#fecha_documento').val(cedula.documentoLegal.fecha);
                        $('#descripcion_documento').val(cedula.documentoLegal.descripcion);
                    }
                }
                // Ver historial de cédula
                $(document).on('click', '.btn-historial', function() {
                    const numeroCedula = $(this).data('numero');

                    $.ajax({
                        url: `{{ url('/') }}/cedulas/${numeroCedula}/historial`,
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                mostrarModalHistorial(response.historial);
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo cargar el historial de la cédula'
                            });
                        }
                    });
                });

                // Función para mostrar el modal de historial
                function mostrarModalHistorial(historial) {
                    let contenidoHistorial = '';

                    historial.forEach(function(cedula, index) {
                        const esActual = index === 0;
                        const badgeColor = esActual ?
                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' :
                            'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
                        const badgeText = esActual ? 'ACTUAL' : 'HISTÓRICA';

                        contenidoHistorial += `
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 ${esActual ? 'bg-green-50 dark:bg-green-900/20' : 'bg-gray-50 dark:bg-gray-800'}">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">Cédula: ${cedula.numero_cedula}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Expediente: ${cedula.numero_expediente}</p>
                    </div>
                    <div class="flex space-x-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${badgeColor}">${badgeText}</span>
                        <button class="btn-ver-detalle px-3 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors" data-cedula='${JSON.stringify(cedula)}'>
                            <i class="fas fa-eye mr-1"></i> Ver Detalle
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Fecha Expedición:</span>
                        <span class="font-medium text-gray-900 dark:text-gray-100">${new Date(cedula.fecha_expedicion).toLocaleDateString('es-ES')}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Vigencia:</span>
                        <span class="font-medium text-gray-900 dark:text-gray-100">${cedula.vigencia_trimestre} TRIMESTRE</span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Tipo:</span>
                        <span class="font-medium text-gray-900 dark:text-gray-100">${cedula.tipo_inmueble}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Ámbito:</span>
                        <span class="font-medium text-gray-900 dark:text-gray-100">${cedula.ambito}</span>
                    </div>
                </div>
            </div>
        `;
                    });

                    Swal.fire({
                        title: 'Historial de Cédula Catastral',
                        html: `
            <div class="text-left max-h-96 overflow-y-auto space-y-4">
                ${contenidoHistorial}
            </div>
        `,
                        showCloseButton: true,
                        showConfirmButton: false,
                        width: '800px',
                        customClass: {
                            popup: 'dark:bg-gray-800',
                            title: 'dark:text-gray-100',
                            htmlContainer: 'dark:text-gray-300'
                        }
                    });
                }

                // Ver detalle de una cédula específica del historial
                $(document).on('click', '.btn-ver-detalle', function() {
                    const cedulaData = JSON.parse($(this).attr('data-cedula'));
                    mostrarDetalleCompleto(cedulaData);
                });

                function mostrarDetalleCompleto(cedula) {
                    const contenidoDetalle = `
        <div class="text-left space-y-6">
            <!-- Información General -->
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="font-semibold text-lg mb-3 text-gray-900 dark:text-gray-100">Información General</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="font-medium">N° Cédula:</span> ${cedula.numero_cedula}</div>
                    <div><span class="font-medium">N° Expediente:</span> ${cedula.numero_expediente}</div>
                    <div><span class="font-medium">Propietario:</span> ${cedula.propietario ? cedula.propietario.nombre_apellido : 'N/A'}</div>
                    <div><span class="font-medium">Cédula Prop.:</span> ${cedula.propietario ? cedula.propietario.cedula : 'N/A'}</div>
                    <div><span class="font-medium">Tipo Inmueble:</span> ${cedula.tipo_inmueble}</div>
                    <div><span class="font-medium">Ámbito:</span> ${cedula.ambito}</div>
                    <div><span class="font-medium">Fecha Expedición:</span> ${new Date(cedula.fecha_expedicion).toLocaleDateString('es-ES')}</div>
                    <div><span class="font-medium">Vigencia:</span> ${cedula.vigencia_trimestre} TRIMESTRE</div>
                </div>
                <div class="mt-3">
                    <div><span class="font-medium">Dirección:</span> ${cedula.direccion_inmueble}</div>
                    ${cedula.avaluo_total ? `<div><span class="font-medium">Avalúo Total:</span> ${new Intl.NumberFormat('es-VE').format(cedula.avaluo_total)} Bs.</div>` : ''}
                    ${cedula.solicitado_para ? `<div><span class="font-medium">Solicitado Para:</span> ${cedula.solicitado_para}</div>` : ''}
                </div>
            </div>

            <!-- Linderos -->
            ${cedula.linderos ? `
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                        <h3 class="font-semibold text-lg mb-3 text-gray-900 dark:text-gray-100">Linderos</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            ${cedula.linderos.norte ? `<div><span class="font-medium">Norte:</span> ${cedula.linderos.norte} ${cedula.linderos.mt2_norte ? `(${cedula.linderos.mt2_norte} m²)` : ''}</div>` : ''}
                            ${cedula.linderos.sur ? `<div><span class="font-medium">Sur:</span> ${cedula.linderos.sur} ${cedula.linderos.mt2_sur ? `(${cedula.linderos.mt2_sur} m²)` : ''}</div>` : ''}
                            ${cedula.linderos.este ? `<div><span class="font-medium">Este:</span> ${cedula.linderos.este} ${cedula.linderos.mt2_este ? `(${cedula.linderos.mt2_este} m²)` : ''}</div>` : ''}
                            ${cedula.linderos.oeste ? `<div><span class="font-medium">Oeste:</span> ${cedula.linderos.oeste} ${cedula.linderos.mt2_oeste ? `(${cedula.linderos.mt2_oeste} m²)` : ''}</div>` : ''}
                        </div>
                        ${cedula.linderos.mt2_total ? `<div class="mt-3 text-sm"><span class="font-medium">Total:</span> ${cedula.linderos.mt2_total} m²</div>` : ''}
                    </div>
                    ` : ''}

            <!-- Documento Legal -->
            ${cedula.documento_legal ? `
                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                        <h3 class="font-semibold text-lg mb-3 text-gray-900 dark:text-gray-100">Documento Legal</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div><span class="font-medium">Tipo:</span> ${cedula.documento_legal.tipo}</div>
                            ${cedula.documento_legal.numero ? `<div><span class="font-medium">Número:</span> ${cedula.documento_legal.numero}</div>` : ''}
                            ${cedula.documento_legal.matricula ? `<div><span class="font-medium">Matrícula:</span> ${cedula.documento_legal.matricula}</div>` : ''}
                            ${cedula.documento_legal.folio ? `<div><span class="font-medium">Folio:</span> ${cedula.documento_legal.folio}</div>` : ''}
                            ${cedula.documento_legal.fecha ? `<div><span class="font-medium">Fecha:</span> ${new Date(cedula.documento_legal.fecha).toLocaleDateString('es-ES')}</div>` : ''}
                        </div>
                        ${cedula.documento_legal.descripcion ? `<div class="mt-3 text-sm"><span class="font-medium">Descripción:</span> ${cedula.documento_legal.descripcion}</div>` : ''}
                    </div>
                    ` : ''}
                </div>
            `;

                    Swal.fire({
                        title: `Detalle de Cédula ${cedula.numero_cedula}`,
                        html: contenidoDetalle,
                        showCloseButton: true,
                        showConfirmButton: false,
                        width: '900px',
                        customClass: {
                            popup: 'dark:bg-gray-800',
                            title: 'dark:text-gray-100',
                            htmlContainer: 'dark:text-gray-300'
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
