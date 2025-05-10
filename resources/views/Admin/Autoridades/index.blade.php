@extends('layouts.admin')

@section('title', 'Autoridades')
@section('header', 'Gestión de Autoridades')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold dark:text-white">Listado de Autoridades</h2>
            <button id="btn-nueva-autoridad" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                <i class="fas fa-plus mr-2"></i>Nueva Autoridad
            </button>
        </div>

        <!-- Tabla de autoridades -->
        <div class="overflow-x-auto">
            <table id="tabla-autoridades" class="min-w-full bg-white dark:bg-gray-800 border dark:border-gray-700">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="py-2 px-4 border-b dark:border-gray-600 text-left">Alcalde</th>
                        <th class="py-2 px-4 border-b dark:border-gray-600 text-left">Director de Recaudación</th>
                        <th class="py-2 px-4 border-b dark:border-gray-600 text-left">Jefe de Catastro</th>
                        <th class="py-2 px-4 border-b dark:border-gray-600 text-left">Alcaldía</th>
                        <th class="py-2 px-4 border-b dark:border-gray-600 text-left">Rif</th>
                        <th class="py-2 px-4 border-b dark:border-gray-600 text-left">Inicio Cargo</th>
                        <th class="py-2 px-4 border-b dark:border-gray-600 text-left">Estado</th>
                        <th class="py-2 px-4 border-b dark:border-gray-600 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($autoridades as $autoridad)
                        <tr class="border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 {{ $autoridad->activo ? 'bg-green-50 dark:bg-green-900/20' : '' }}">
                            <td class="py-2 px-4">{{ $autoridad->alcalde }}</td>
                            <td class="py-2 px-4">{{ $autoridad->director_recaudacion }}</td>
                            <td class="py-2 px-4">{{ $autoridad->jefe_catastro }}</td>
                            <td class="py-2 px-4">{{ $autoridad->nombre_alcaldia }}</td>
                            <td class="py-2 px-4">{{ $autoridad->rif_alcaldia }}</td>
                            <td class="py-2 px-4">{{ $autoridad->fecha_inicio_cargo ? date('d/m/Y', strtotime($autoridad->fecha_inicio_cargo)) : 'N/A' }}</td>
                            <td class="py-2 px-4">
                                <span class="px-2 py-1 rounded-full text-xs {{ $autoridad->activo ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $autoridad->activo ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="py-2 px-4">
                                <div class="flex space-x-2">
                                    <button class="btn-editar text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"
                                            data-id="{{ $autoridad->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if(!$autoridad->activo)
                                        <button class="btn-activar text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200"
                                                data-id="{{ $autoridad->id }}">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    @endif
                                    <button class="btn-eliminar text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200"
                                            data-id="{{ $autoridad->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para crear/editar autoridad -->
    <div id="modal-autoridad" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4">
            <div class="flex justify-between items-center border-b dark:border-gray-700 p-4">
                <h3 class="text-lg font-semibold" id="modal-title">Nueva Autoridad</h3>
                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100" id="btn-cerrar-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form id="form-autoridad">
                    <input type="hidden" id="autoridad-id" name="id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="nombre_alcaldia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre de la Alcaldía</label>
                            <input type="text" id="nombre_alcaldia" name="nombre_alcaldia" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="rif_alcaldia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">RIF de la Alcaldía</label>
                            <input type="text" id="rif_alcaldia" name="rif_alcaldia" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="alcalde" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alcalde</label>
                            <input type="text" id="alcalde" name="alcalde" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="director_recaudacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Director de Recaudación</label>
                            <input type="text" id="director_recaudacion" name="director_recaudacion" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="jefe_catastro" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jefe de Catastro</label>
                            <input type="text" id="jefe_catastro" name="jefe_catastro" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="fecha_inicio_cargo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha Inicio Cargo</label>
                            <input type="date" id="fecha_inicio_cargo" name="fecha_inicio_cargo" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="activo" name="activo" class="rounded border-gray-300 text-primary focus:ring-primary dark:border-gray-600 dark:bg-gray-700">
                            <label for="activo" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Establecer como autoridad activa</label>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 mr-2" id="btn-cancelar">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/catastro/jquery.js') }}"></script>
        <script src="{{ asset('js/catastro/dataTables.min.js') }}"></script>
        <script src="{{ asset('js/catastro/responsive.dataTables.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar DataTable
                const table = $('#tabla-autoridades').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                    },
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 }, // Alcalde
                        { responsivePriority: 2, targets: 6 }, // Estado
                        { responsivePriority: 3, targets: 7 }, // Acciones
                    ]
                });

                // Modal y formulario
                const modal = document.getElementById('modal-autoridad');
                const form = document.getElementById('form-autoridad');
                const btnNueva = document.getElementById('btn-nueva-autoridad');
                const btnCerrar = document.getElementById('btn-cerrar-modal');
                const btnCancelar = document.getElementById('btn-cancelar');
                const modalTitle = document.getElementById('modal-title');

                // Abrir modal para nueva autoridad
                btnNueva.addEventListener('click', function() {
                    modalTitle.textContent = 'Nueva Autoridad';
                    form.reset();
                    document.getElementById('autoridad-id').value = '';
                    modal.classList.remove('hidden');
                });

                // Cerrar modal
                [btnCerrar, btnCancelar].forEach(btn => {
                    btn.addEventListener('click', function() {
                        modal.classList.add('hidden');
                    });
                });

                // Editar autoridad
                document.querySelectorAll('.btn-editar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        modalTitle.textContent = 'Editar Autoridad';

                        // Obtener datos de la autoridad
                        fetch(`/autoridades/${id}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const autoridad = data.autoridad;
                                    document.getElementById('autoridad-id').value = autoridad.id;
                                    document.getElementById('alcalde').value = autoridad.alcalde;
                                    document.getElementById('director_recaudacion').value = autoridad.director_recaudacion;
                                    document.getElementById('jefe_catastro').value = autoridad.jefe_catastro;
                                    document.getElementById('nombre_alcaldia').value = autoridad.nombre_alcaldia;
                                    document.getElementById('rif_alcaldia').value = autoridad.rif_alcaldia;
                                    document.getElementById('fecha_inicio_cargo').value = autoridad.fecha_inicio_cargo ? autoridad.fecha_inicio_cargo.split('T')[0] : '';
                                    document.getElementById('activo').checked = autoridad.activo;

                                    modal.classList.remove('hidden');
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'No se pudo cargar la información de la autoridad'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error al cargar la autoridad'
                                });
                            });
                    });
                });

                // Enviar formulario
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const data = {};
                    formData.forEach((value, key) => {
                        data[key] = key === 'activo' ? true : value;
                    });

                    // Si no está marcado como activo y el checkbox existe, añadir false
                    if (!formData.has('activo')) {
                        data.activo = false;
                    }

                    fetch('/autoridades/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: data.message,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            let errorMessage = 'Verifica los datos e inténtalo de nuevo';
                            if (data.errors) {
                                errorMessage = Object.values(data.errors).flat().join('<br>');
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: errorMessage
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud'
                        });
                    });
                });

                // Activar autoridad
                document.querySelectorAll('.btn-activar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');

                        Swal.fire({
                            title: '¿Activar autoridad?',
                            text: 'Esta acción desactivará cualquier otra autoridad activa',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, activar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`/autoridades/activar/${id}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Éxito!',
                                            text: data.message,
                                            timer: 1500
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: data.message
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Ocurrió un error al procesar la solicitud'
                                    });
                                });
                            }
                        });
                    });
                });

                // Eliminar autoridad
                document.querySelectorAll('.btn-eliminar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');

                        Swal.fire({
                            title: '¿Eliminar autoridad?',
                            text: 'Esta acción no se puede deshacer',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#d33'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`/autoridades/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Éxito!',
                                            text: data.message,
                                            timer: 1500
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: data.message
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Ocurrió un error al procesar la solicitud'
                                    });
                                });
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
