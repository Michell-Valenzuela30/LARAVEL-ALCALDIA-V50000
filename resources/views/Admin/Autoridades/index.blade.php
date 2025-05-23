@extends('layouts.admin')

@section('title', 'Autoridades')
@section('header', 'Gestión de Autoridades')

@section('content')
    <!-- Card de Información de la Alcaldía -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold dark:text-white">Información de la Alcaldía</h2>
            <button id="btn-editar-alcaldia" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                <i class="fas fa-edit mr-2"></i>Editar Información
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Nombre de la Alcaldía</p>
                <p class="text-lg font-medium dark:text-white" id="nombre-alcaldia-display">
                    {{ $infoAlcaldia->nombre ?? 'No configurado' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">RIF de la Alcaldía</p>
                <p class="text-lg font-medium dark:text-white" id="rif-alcaldia-display">
                    {{ $infoAlcaldia->rif ?? 'No configurado' }}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold dark:text-white">Autoridades Activas</h2>
            <div class="flex space-x-2">
                <button id="btn-ver-historial" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    <i class="fas fa-history mr-2"></i>Ver Historial
                </button>
                <button id="btn-nueva-autoridad" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                    <i class="fas fa-plus mr-2"></i>Nueva Autoridad
                </button>
            </div>
        </div>

        <!-- Cards de autoridades activas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($tipos as $tipoKey => $tipoNombre)
                @php
                    $autoridadActiva = $autoridadesActivas[$tipoKey] ?? null;
                @endphp
                <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $tipoNombre }}</h3>
                        @if ($autoridadActiva)
                            <span
                                class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs rounded-full">
                                Activo
                            </span>
                        @else
                            <span
                                class="px-2 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 text-xs rounded-full">
                                Sin asignar
                            </span>
                        @endif
                    </div>

                    @if ($autoridadActiva)
                        <div class="space-y-2">
                            <p class="text-gray-900 dark:text-white font-medium">{{ $autoridadActiva->nombre }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                <i class="fas fa-calendar mr-1"></i>
                                Desde: {{ $autoridadActiva->fecha_inicio_cargo->format('d/m/Y') }}
                            </p>
                        </div>

                        <div class="mt-4 flex space-x-2">
                            <button
                                class="btn-cambiar text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-sm"
                                data-tipo="{{ $tipoKey }}" data-tipo-nombre="{{ $tipoNombre }}">
                                <i class="fas fa-exchange-alt mr-1"></i>Cambiar
                            </button>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-plus text-gray-400 text-3xl mb-2"></i>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">No hay autoridad asignada</p>
                            <button
                                class="btn-asignar px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark text-sm"
                                data-tipo="{{ $tipoKey }}" data-tipo-nombre="{{ $tipoNombre }}">
                                <i class="fas fa-plus mr-1"></i>Asignar
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal para agregar/cambiar autoridad -->
    <div id="modal-autoridad" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="flex justify-between items-center border-b dark:border-gray-700 p-4">
                <h3 class="text-lg font-semibold" id="modal-title">Nueva Autoridad</h3>
                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100"
                    id="btn-cerrar-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form id="form-autoridad">
                    <input type="hidden" id="tipo" name="tipo">

                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre
                            Completo</label>
                        <input type="text" id="nombre" name="nombre"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="fecha_inicio_cargo"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha Inicio
                            Cargo</label>
                        <input type="date" id="fecha_inicio_cargo" name="fecha_inicio_cargo"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            required>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
                            id="btn-cancelar">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para ver historial -->
    <div id="modal-historial" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[80vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b dark:border-gray-700 p-4">
                <h3 class="text-lg font-semibold dark:text-white">Historial de Autoridades</h3>
                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100"
                    id="btn-cerrar-historial">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                @foreach ($tipos as $tipoKey => $tipoNombre)
                    @if (isset($autoridadesInactivas[$tipoKey]) && $autoridadesInactivas[$tipoKey]->count() > 0)
                        <div class="mb-6">
                            <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">{{ $tipoNombre }}</h4>
                            <div class="space-y-2">
                                @foreach ($autoridadesInactivas[$tipoKey] as $autoridad)
                                    <div
                                        class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $autoridad->nombre }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                Desde: {{ $autoridad->fecha_inicio_cargo->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <button
                                            class="btn-reactivar px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 text-sm"
                                            data-id="{{ $autoridad->id }}">
                                            <i class="fas fa-undo mr-1"></i>Reactivar
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                @if ($autoridadesInactivas->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-history text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400">No hay autoridades anteriores</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para editar información de alcaldía -->
    <div id="modal-alcaldia" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="flex justify-between items-center border-b dark:border-gray-700 p-4">
                <h3 class="text-lg font-semibold dark:text-white">Información de la Alcaldía</h3>
                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100"
                    id="btn-cerrar-modal-alcaldia">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form id="form-alcaldia">
                    <div class="mb-4">
                        <label for="nombre_alcaldia_modal"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre de la
                            Alcaldía</label>
                        <input type="text" id="nombre_alcaldia_modal" name="nombre"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="rif_alcaldia_modal"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">RIF de la
                            Alcaldía</label>
                        <input type="text" id="rif_alcaldia_modal" name="rif"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            required>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
                            id="btn-cancelar-alcaldia">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/catastro/jquery.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Elementos del DOM
                const modalAutoridad = document.getElementById('modal-autoridad');
                const modalHistorial = document.getElementById('modal-historial');
                const formAutoridad = document.getElementById('form-autoridad');
                const modalTitle = document.getElementById('modal-title');

                // Botones principales
                const btnNuevaAutoridad = document.getElementById('btn-nueva-autoridad');
                const btnVerHistorial = document.getElementById('btn-ver-historial');

                // Botones de modal
                const btnCerrarModal = document.getElementById('btn-cerrar-modal');
                const btnCerrarHistorial = document.getElementById('btn-cerrar-historial');
                const btnCancelar = document.getElementById('btn-cancelar');
                // Elementos para modal de alcaldía
                const modalAlcaldia = document.getElementById('modal-alcaldia');
                const formAlcaldia = document.getElementById('form-alcaldia');
                const btnEditarAlcaldia = document.getElementById('btn-editar-alcaldia');
                const btnCerrarModalAlcaldia = document.getElementById('btn-cerrar-modal-alcaldia');
                const btnCancelarAlcaldia = document.getElementById('btn-cancelar-alcaldia');

                // Abrir modal para nueva autoridad (sin tipo específico)
                btnNuevaAutoridad.addEventListener('click', function() {
                    abrirModalAutoridad('nueva', null, 'Nueva Autoridad');
                });

                // Abrir modal historial
                btnVerHistorial.addEventListener('click', function() {
                    modalHistorial.classList.remove('hidden');
                });

                // Cerrar modales
                [btnCerrarModal, btnCancelar].forEach(btn => {
                    btn.addEventListener('click', () => modalAutoridad.classList.add('hidden'));
                });

                btnCerrarHistorial.addEventListener('click', () => modalHistorial.classList.add('hidden'));

                // Eventos para modal de alcaldía
                btnEditarAlcaldia.addEventListener('click', function() {
                    // Cargar datos actuales
                    document.getElementById('nombre_alcaldia_modal').value = document.getElementById(
                        'nombre-alcaldia-display').textContent.trim();
                    document.getElementById('rif_alcaldia_modal').value = document.getElementById(
                        'rif-alcaldia-display').textContent.trim();
                    modalAlcaldia.classList.remove('hidden');
                });

                [btnCerrarModalAlcaldia, btnCancelarAlcaldia].forEach(btn => {
                    btn.addEventListener('click', () => modalAlcaldia.classList.add('hidden'));
                });

                // Enviar formulario de alcaldía
                formAlcaldia.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(formAlcaldia);
                    const data = Object.fromEntries(formData.entries());

                    fetch('/alcaldia/actualizar', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('nombre-alcaldia-display').textContent = data
                                    .alcaldia.nombre;
                                document.getElementById('rif-alcaldia-display').textContent = data.alcaldia
                                    .rif;
                                modalAlcaldia.classList.add('hidden');

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: 'Información actualizada correctamente',
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Error al actualizar la información'
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

                // Botones para asignar autoridad
                document.querySelectorAll('.btn-asignar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const tipo = this.getAttribute('data-tipo');
                        const tipoNombre = this.getAttribute('data-tipo-nombre');
                        abrirModalAutoridad('asignar', tipo, `Asignar ${tipoNombre}`);
                    });
                });

                // Botones para cambiar autoridad
                document.querySelectorAll('.btn-cambiar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const tipo = this.getAttribute('data-tipo');
                        const tipoNombre = this.getAttribute('data-tipo-nombre');
                        abrirModalAutoridad('cambiar', tipo, `Cambiar ${tipoNombre}`);
                    });
                });

                // Botones para reactivar autoridad
                document.querySelectorAll('.btn-reactivar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        reactivarAutoridad(id);
                    });
                });

                // Función para abrir modal
                function abrirModalAutoridad(accion, tipo, titulo) {
                    modalTitle.textContent = titulo;
                    formAutoridad.reset();

                    if (tipo) {
                        document.getElementById('tipo').value = tipo;
                    } else {
                        // Si no hay tipo específico, crear un select
                        crearSelectTipo();
                    }

                    modalAutoridad.classList.remove('hidden');
                }

                // Crear select para elegir tipo de autoridad
                function crearSelectTipo() {
                    const tipoInput = document.getElementById('tipo');
                    const container = tipoInput.parentElement;

                    // Crear label
                    const label = document.createElement('label');
                    label.setAttribute('for', 'tipo');
                    label.className = 'block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1';
                    label.textContent = 'Tipo de Autoridad';

                    // Crear select
                    const select = document.createElement('select');
                    select.id = 'tipo';
                    select.name = 'tipo';
                    select.className = tipoInput.className;
                    select.required = true;

                    // Agregar opciones
                    select.innerHTML = `
                        <option value="">Seleccionar tipo de autoridad</option>
                        <option value="director_recaudacion">Director de Recaudación</option>
                        <option value="alcalde">Alcalde</option>
                        <option value="jefe_catastro">Jefe de Catastro</option>
                    `;

                    // Limpiar container y agregar elementos
                    container.innerHTML = '';
                    container.appendChild(label);
                    container.appendChild(select);
                }

                // Enviar formulario
                formAutoridad.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(formAutoridad);
                    const data = Object.fromEntries(formData.entries());

                    fetch('/autoridades/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
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

                // Función para reactivar autoridad
                function reactivarAutoridad(id) {
                    Swal.fire({
                        title: '¿Reactivar autoridad?',
                        text: 'Esta acción desactivará la autoridad actual del mismo tipo',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, reactivar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/autoridades/activar/${id}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content')
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
                }
            });
        </script>
    @endpush
@endsection
