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

        <div class="overflow-x-auto">
            <table id="tabla-cedulas" class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3">N° Cédula</th>
                        <th class="px-4 py-3">N° Expediente</th>
                        <th class="px-4 py-3">Propietario</th>
                        <th class="px-4 py-3">Tipo Inmueble</th>
                        <th class="px-4 py-3">Ámbito</th>
                        <th class="px-4 py-3">Fecha Expedición</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <h4 class="text-lg font-medium col-span-full mb-0 pb-2 border-b dark:border-gray-700">Datos
                            Principales</h4>

                        <div>
                            <label for="numero_cedula" class="block mb-2 text-sm font-medium">Número de Cédula</label>
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

                        <div>
                            <label for="nombre_apellido" class="block mb-2 text-sm font-medium">Nombre y Apellido</label>
                            <input type="text" id="nombre_apellido" name="nombre_apellido"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            <div class="text-red-500 text-xs mt-1 error-nombre_apellido"></div>
                        </div>

                        <div>
                            <label for="cedula" class="block mb-2 text-sm font-medium">Cédula de Identidad</label>
                            <input type="text" id="cedula" name="cedula" placeholder="V-12345678"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            <div class="text-red-500 text-xs mt-1 error-cedula"></div>
                        </div>

                        <div>
                            <label for="rif" class="block mb-2 text-sm font-medium">RIF (Opcional)</label>
                            <input type="text" id="rif" name="rif" placeholder="J-12345678-9"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <div>
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
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <h4 class="text-lg font-medium col-span-full mb-0 pb-2 border-b dark:border-gray-700">Linderos</h4>

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

                        <div>
                            <label for="mt2_total" class="block mb-2 text-sm font-medium">Metros Totales</label>
                            <input type="number" step="0.01" id="mt2_total" name="mt2_total"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <h4 class="text-lg font-medium col-span-full mb-0 pb-2 border-b dark:border-gray-700">Documentos
                            Legales</h4>

                        <div>
                            <label for="tipo_documento" class="block mb-2 text-sm font-medium">Tipo de Documento</label>
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

                        <div>
                            <label for="descripcion_documento" class="block mb-2 text-sm font-medium">Descripción</label>
                            <textarea id="descripcion_documento" name="descripcion_documento" rows="2"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <h4 class="text-lg font-medium col-span-full mb-0 pb-2 border-b dark:border-gray-700">Información
                            Adicional</h4>

                        <div>
                            <label for="avaluo_total" class="block mb-2 text-sm font-medium">Avalúo Total (Bs.)</label>
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
                            <label for="solicitado_para" class="block mb-2 text-sm font-medium">Solicitado Para</label>
                            <input type="text" id="solicitado_para" name="solicitado_para"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <div>
                            <label for="dato_opcional_1" class="block mb-2 text-sm font-medium">Dato Opcional 1</label>
                            <input type="number" id="dato_opcional_1" name="dato_opcional_1"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <div>
                            <label for="dato_opcional_2" class="block mb-2 text-sm font-medium">Dato Opcional 2</label>
                            <input type="number" id="dato_opcional_2" name="dato_opcional_2"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <div>
                            <label for="dato_opcional_3" class="block mb-2 text-sm font-medium">Dato Opcional 3</label>
                            <input type="number" id="dato_opcional_3" name="dato_opcional_3"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <div>
                            <label for="dato_opcional_texto" class="block mb-2 text-sm font-medium">Dato Opcional
                                (Texto)</label>
                            <input type="text" id="dato_opcional_texto" name="dato_opcional_texto"
                                class="w-full p-2.5 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8">
                        <button type="button" id="cancelar-cedula"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md">Cancelar</button>
                        <button type="submit" id="guardar-cedula"
                            class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-md">Guardar</button>
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

    @push('scripts')
        <script src="{{ asset('js/catastro/jquery.js') }}"></script>
        <script src="{{ asset('js/catastro/dataTables.min.js') }}"></script>
        <script src="{{ asset('js/catastro/responsive.dataTables.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                // Configuración de DataTables
                const tabla = $('#tabla-cedulas').DataTable({
                    responsive: true,
                    processing: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
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
                            data: 'numero_cedula'
                        },
                        {
                            data: 'numero_expediente'
                        },
                        {
                            data: 'propietario.nombre_apellido',
                            defaultContent: 'N/A',
                            render: function(data, type, row) {
                                return row.propietario ? row.propietario.nombre_apellido : 'N/A';
                            }
                        },
                        {
                            data: 'tipo_inmueble'
                        },
                        {
                            data: 'ambito'
                        },
                        {
                            data: 'fecha_expedicion',
                            render: function(data) {
                                return new Date(data).toLocaleDateString('es-ES');
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            render: function(data) {
                                return `
                                    <div class="flex space-x-2">
                                        <button class="btn-editar text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" data-id="${data.id}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-eliminar text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" data-id="${data.id}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                `;
                            }
                        }
                    ]
                });

                // Modal de Nueva Cédula
                $('#btn-nueva-cedula').click(function() {
                    resetearFormulario();
                    $('#modal-title').text('Nueva Cédula Catastral');
                    $('#modal-cedula').removeClass('hidden');
                });

                // Cerrar modal
                $('#close-modal, #cancelar-cedula').click(function() {
                    $('#modal-cedula').addClass('hidden');
                });

                // Editar cédula
                $(document).on('click', '.btn-editar', function() {
                    const id = $(this).data('id');

                    $.ajax({
                        url: `/cedulas/${id}`,
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                cargarDatosFormulario(response.cedula);
                                $('#modal-title').text('Editar Cédula Catastral');
                                $('#modal-cedula').removeClass('hidden');
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
                    $('#dato_opcional_1').val(cedula.dato_opcional_1);
                    $('#dato_opcional_2').val(cedula.dato_opcional_2);
                    $('#dato_opcional_3').val(cedula.dato_opcional_3);
                    $('#dato_opcional_texto').val(cedula.dato_opcional_texto);

                    // Datos del propietario
                    if (cedula.propietario) {
                        $('#nombre_apellido').val(cedula.propietario.nombre_apellido);
                        $('#cedula').val(cedula.propietario.cedula);
                        $('#rif').val(cedula.propietario.rif);
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
            });
        </script>
    @endpush
@endsection
