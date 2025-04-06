@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')
@section('header', 'Gestión de Usuarios')

@section('content')
    <div class="card mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold">Lista de Usuarios</h2>
                <p class="text-gray-600 dark:text-gray-400">Administración de usuarios del sistema</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <input type="text" id="search-users" placeholder="Buscar usuarios..." class="input pr-10">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>

                <button id="btn-new-user" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Nuevo Usuario
                </button>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Rol
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Creado
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody id="usuarios-table-body"
                    class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Los datos de usuarios se cargarán aquí -->
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Cargando usuarios...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t dark:border-gray-700">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600 dark:text-gray-400" id="pagination-info">
                    Mostrando <span id="pagination-from">0</span> a <span id="pagination-to">0</span> de <span
                        id="pagination-total">0</span> resultados
                </div>
                <div class="flex space-x-2" id="pagination-buttons">
                    <!-- Botones de paginación -->
                </div>
            </div>
        </div>
    </div>

    <!-- Template para modal de creación/edición de usuario -->
    <template id="user-modal-template">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold" id="modal-title">Nuevo Usuario</h3>
                <button onclick="closeModal()"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div id="user-form-errors"
                class="mb-4 p-3 bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300 rounded-md hidden"></div>

            <form id="user-form" class="space-y-4">
                <input type="hidden" id="user-id">

                <div>
                    <label for="user-name" class="block mb-1 font-medium">Nombre</label>
                    <input type="text" id="user-name" name="name" class="input" required>
                </div>

                <div>
                    <label for="user-email" class="block mb-1 font-medium">Correo electrónico</label>
                    <input type="email" id="user-email" name="email" class="input" required>
                </div>

                <div>
                    <label for="user-password" class="block mb-1 font-medium">Contraseña</label>
                    <input type="password" id="user-password" name="password" class="input"
                        placeholder="Dejar en blanco para no cambiar">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Mínimo 8 caracteres</p>
                </div>

                <div>
                    <label for="user-role" class="block mb-1 font-medium">Rol</label>
                    <select id="user-role" name="role" class="input">
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
                        <option value="root">Root</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal()" class="btn btn-secondary">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span id="modal-btn-text">Guardar</span>
                        <span id="modal-spinner" class="ml-2 hidden">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </template>

    <!-- Template para modal de confirmación de eliminación -->
    <template id="delete-modal-template">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-red-600 dark:text-red-500">Eliminar Usuario</h3>
                <button onclick="closeModal()"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <p class="mb-6">¿Estás seguro de que deseas eliminar al usuario <strong id="delete-user-name"></strong>?
                Esta
                acción no se puede deshacer.</p>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">
                    Cancelar
                </button>
                <button id="confirm-delete-btn" class="btn bg-red-600 hover:bg-red-700 text-white">
                    <span>Eliminar</span>
                    <span id="delete-spinner" class="ml-2 hidden">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </button>
            </div>
        </div>
    </template>

    @push('scripts')
        <script>
            window.currentUser = @json(auth()->check() ? ['id' => auth()->user()->id, 'role' => auth()->user()->role->name] : null);
            // Variables globales para paginación
            let currentPage = 1;
            let lastPage = 1;
            let usersList = [];
            let filteredUsers = [];
            // Usar el rol del usuario obtenido desde la sesión
            const currentUserRole = window.currentUserRole;

            // Función para cargar usuarios
            async function loadUsers(page = 1) {
                try {
                    const tableBody = document.getElementById('usuarios-table-body');
                    tableBody.innerHTML =
                        `
                                                                                                                                                                                        <tr>
                                                                                                                                                                                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                                                                                                                                                                                <i class="fas fa-spinner fa-spin mr-2"></i> Cargando usuarios...
                                                                                                                                                                                            </td>
                                                                                                                                                                                        </tr>
                                                                                                                                                                                    `;

                    const response = await fetch(`/api/usuarios?page=${page}`, {
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Error al cargar usuarios');
                    }

                    const data = await response.json();

                    // Guardar datos para búsqueda y filtrado
                    usersList = data.data || data;
                    filteredUsers = [...usersList];

                    // Actualizar vista con datos
                    renderUsers(usersList);

                    // Configurar paginación si está disponible
                    if (data.meta) {
                        setupPagination(data.meta);
                        currentPage = data.meta.current_page;
                        lastPage = data.meta.last_page;
                    }
                } catch (error) {
                    console.error('Error al cargar usuarios:', error);
                    document.getElementById('usuarios-table-body').innerHTML =
                        `
                                                                                                                                                                                        <tr>
                                                                                                                                                                                            <td colspan="6" class="px-6 py-4 text-center text-red-500">
                                                                                                                                                                                                <i class="fas fa-exclamation-circle mr-2"></i> Error al cargar usuarios
                                                                                                                                                                                            </td>
                                                                                                                                                                                        </tr>
                                                                                                                                                                                    `;
                }
            }

            // Función para renderizar usuarios
            function renderUsers(users) {
                const tableBody = document.getElementById('usuarios-table-body');

                // Si el usuario actual es admin, filtramos los usuarios root
                if (window.currentUser && window.currentUser.role === 'admin') {
                    users = users.filter(user => user.role.name !== 'root');
                }

                if (!users || users.length === 0) {
                    tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No se encontraron usuarios
                        </td>
                    </tr>
                `;
                    return;
                }

                tableBody.innerHTML = users.map(user => {
                    const isCurrentUser = window.currentUser && window.currentUser.id === user.id;

                    // Definir el texto y el color del badge basado en el rol
                    let roleText = 'USER';
                    let roleBadgeClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';

                    if (user.role.name === 'root') {
                        roleText = 'ROOT';
                        roleBadgeClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                    } else if (user.role.name === 'admin') {
                        roleText = 'ADMIN';
                        roleBadgeClass = 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300';
                    }

                    return `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">${user.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center mr-3">
                                    <span class="text-gray-600 dark:text-gray-300">${user.name.charAt(0).toUpperCase()}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">${user.name}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">${user.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${roleBadgeClass}">
                                ${roleText}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            ${new Date(user.created_at).toLocaleDateString()}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            ${isCurrentUser ? `
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                            Usuario Actual
                                                        </span>
                                                    ` : `
                                                        <button class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3"
                                                            onclick="editUser(${user.id})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                            onclick="deleteUser(${user.id}, '${user.name}')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    `}
                        </td>
                    </tr>
                `;
                }).join('');
            }

            // Configurar paginación
            function setupPagination(meta) {
                const paginationInfo = document.getElementById('pagination-info');
                const paginationButtons = document.getElementById('pagination-buttons');

                // Actualizar información de paginación
                document.getElementById('pagination-from').textContent = meta.from || 0;
                document.getElementById('pagination-to').textContent = meta.to || 0;
                document.getElementById('pagination-total').textContent = meta.total || 0;

                // Crear botones de paginación
                let buttons = '';

                // Botón anterior
                buttons +=
                    `
                                                                                                                                                                                    <button
                                                                                                                                                                                        class="px-3 py-1 rounded-md ${meta.current_page <= 1 ? 'bg-gray-200 text-gray-500 cursor-not-allowed dark:bg-gray-700' : 'bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'}"
                                                                                                                                                                                        ${meta.current_page <= 1 ? 'disabled' : `onclick="loadUsers(${meta.current_page - 1})"`}>
                                                                                                                                                                                        <i class="fas fa-chevron-left"></i>
                                                                                                                                                                                    </button>
                                                                                                                                                                                `;

                // Números de página
                const totalPages = meta.last_page;
                const currentPage = meta.current_page;

                let startPage = Math.max(currentPage - 2, 1);
                let endPage = Math.min(startPage + 4, totalPages);

                if (endPage - startPage < 4 && totalPages > 5) {
                    startPage = Math.max(endPage - 4, 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    buttons +=
                        `
                                                                                                                                                                                        <button
                                                                                                                                                                                            class="px-3 py-1 rounded-md ${i === currentPage ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'}"
                                                                                                                                                                                            onclick="loadUsers(${i})">
                                                                                                                                                                                            ${i}
                                                                                                                                                                                        </button>
                                                                                                                                                                                    `;
                }

                // Botón siguiente
                buttons +=
                    `
                                                                                                                                                                                    <button
                                                                                                                                                                                        class="px-3 py-1 rounded-md ${meta.current_page >= meta.last_page ? 'bg-gray-200 text-gray-500 cursor-not-allowed dark:bg-gray-700' : 'bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'}"
                                                                                                                                                                                        ${meta.current_page >= meta.last_page ? 'disabled' : `onclick="loadUsers(${meta.current_page + 1})"`}>
                                                                                                                                                                                        <i class="fas fa-chevron-right"></i>
                                                                                                                                                                                    </button>
                                                                                                                                                                                `;

                paginationButtons.innerHTML = buttons;
            }

            // Crear nuevo usuario
            function openNewUserModal() {
                const template = document.getElementById("user-modal-template");
                openModal(template.innerHTML);

                document.getElementById("modal-title").textContent = "Nuevo Usuario";
                document.getElementById("modal-btn-text").textContent = "Crear Usuario";

                // Limpiar formulario
                document.getElementById("user-id").value = "";
                document.getElementById("user-form").reset();

                // Mostrar u ocultar la opción "root" según el rol actual
                if (currentUserRole === "admin") {
                    hideRootRoleOption();
                } else if (currentUserRole === "root") {
                    showRootRoleOption();
                }

                // Asignar evento
                document
                    .getElementById("user-form")
                    .addEventListener("submit", saveUser);
            }

            // Editar usuario
            async function editUser(userId) {
                try {
                    const response = await fetch(`/api/usuarios/${userId}`, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                        "auth_token"
                    )}`,
                            Accept: "application/json",
                        },
                    });

                    if (!response.ok) {
                        throw new Error("Error al obtener datos del usuario");
                    }

                    const user = await response.json();

                    // Abrir modal
                    const template = document.getElementById("user-modal-template");
                    openModal(template.innerHTML);

                    // Esperar un instante para asegurarnos de que el modal se insertó en el DOM
                    setTimeout(() => {
                        // Configurar formulario
                        document.getElementById("modal-title").textContent =
                            "Editar Usuario";
                        document.getElementById("modal-btn-text").textContent =
                            "Actualizar Usuario";

                        // Llenar datos
                        document.getElementById("user-id").value = user.id || "";
                        document.getElementById("user-name").value = user.name || "";
                        document.getElementById("user-email").value = user.email || "";
                        // No asignamos la contraseña por razones de seguridad
                        document.getElementById("user-password").value = "";

                        // Manejo del campo role (simplificado y mejorado)
                        let roleValue = "user"; // valor predeterminado
                        if (user.role) {
                            roleValue =
                                typeof user.role === "object" ?
                                user.role.name :
                                user.role;
                        }
                        document.getElementById("user-role").value = roleValue;

                        // Mostrar u ocultar la opción "root" según el rol actual
                        if (currentUserRole === "admin") {
                            hideRootRoleOption();
                        } else if (currentUserRole === "root") {
                            showRootRoleOption();
                        }

                        // Evitar duplicar event listeners
                        const form = document.getElementById("user-form");
                        form.removeEventListener("submit", saveUser);
                        form.addEventListener("submit", saveUser);
                    }, 100);
                } catch (error) {
                    console.error("Error al editar usuario:", error);
                    alert("Error al cargar los datos del usuario");
                }
            }

            // Guardar usuario (crear/actualizar)
            async function saveUser(e) {
                e.preventDefault();

                const userId = document.getElementById("user-id").value;
                const isNew = !userId;

                const formData = {
                    name: document.getElementById("user-name").value,
                    email: document.getElementById("user-email").value,
                    role: document.getElementById("user-role").value,
                };

                const password = document.getElementById("user-password").value;
                if (password) {
                    formData.password = password;
                    if (isNew) {
                        formData.password_confirmation = password;
                    }
                }

                const spinner = document.getElementById("modal-spinner");
                const errorDiv = document.getElementById("user-form-errors");

                try {
                    spinner.classList.remove("hidden");
                    errorDiv.classList.add("hidden");

                    const url = isNew ? "/api/usuarios" : `/api/usuarios/${userId}`;
                    const method = isNew ? "POST" : "PATCH"; // Cambio de PUT a PATCH

                    const response = await fetch(url, {
                        method,
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${localStorage.getItem(
                        "auth_token"
                    )}`,
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                            Accept: "application/json", // Añadido para asegurar respuesta JSON
                        },
                        body: JSON.stringify(formData),
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        let errorMessage = "Error al guardar usuario";
                        if (data.message) {
                            errorMessage = data.message;
                        } else if (data.errors) {
                            // Formatear errores de validación
                            errorMessage = Object.values(data.errors)
                                .flat()
                                .join("<br>");
                        }
                        throw new Error(errorMessage);
                    }

                    // Cerrar modal y recargar usuarios
                    closeModal();
                    loadUsers(currentPage);
                } catch (error) {
                    console.error("Error al guardar usuario:", error);

                    errorDiv.innerHTML =
                        error.message ||
                        "Error al guardar usuario. Intente nuevamente.";
                    errorDiv.classList.remove("hidden");
                } finally {
                    spinner.classList.add("hidden");
                }
            }

            // Confirmar eliminación
            function deleteUser(userId, userName) {
                const template = document.getElementById("delete-modal-template");
                openModal(template.innerHTML);

                document.getElementById("delete-user-name").textContent = userName;

                document
                    .getElementById("confirm-delete-btn")
                    .addEventListener("click", async () => {
                        const spinner = document.getElementById("delete-spinner");

                        try {
                            spinner.classList.remove("hidden");

                            const response = await fetch(`/api/usuarios/${userId}`, {
                                method: "DELETE",
                                headers: {
                                    Authorization: `Bearer ${localStorage.getItem(
                                "auth_token"
                            )}`,
                                    "X-CSRF-TOKEN": document
                                        .querySelector('meta[name="csrf-token"]')
                                        .getAttribute("content"),
                                },
                            });

                            if (!response.ok) {
                                throw new Error("Error al eliminar usuario");
                            }

                            // Cerrar modal y recargar usuarios
                            closeModal();

                            // Si era el último elemento de la página actual y no es la primera página
                            if (usersList.length === 1 && currentPage > 1) {
                                loadUsers(currentPage - 1);
                            } else {
                                loadUsers(currentPage);
                            }
                        } catch (error) {
                            console.error("Error al eliminar usuario:", error);
                            alert("Error al eliminar usuario. Intente nuevamente.");
                        } finally {
                            spinner.classList.add("hidden");
                        }
                    });
            }

            // Inicializar página
            document.addEventListener('DOMContentLoaded', () => {
                // Cargar usuarios
                loadUsers();

                // Configurar búsqueda
                const searchInput = document.getElementById('search-users');
                searchInput.addEventListener('input', (e) => {
                    searchUsers(e.target.value);
                });

                // Configurar botón nuevo usuario
                document.getElementById('btn-new-user').addEventListener('click', openNewUserModal);
            });

            // Función de modal genérica
            function openModal(content) {
                // Crear elementos del modal
                const modalOverlay = document.createElement('div');
                modalOverlay.id = 'modal-overlay';
                modalOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center';

                const modalContainer = document.createElement('div');
                modalContainer.id = 'modal-container';
                modalContainer.className = 'bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4 z-50';
                modalContainer.innerHTML = content;

                // Agregar al DOM
                modalOverlay.appendChild(modalContainer);
                document.body.appendChild(modalOverlay);

                // Prevenir scroll en el body
                document.body.classList.add('overflow-hidden');

                // Cerrar modal al hacer clic fuera
                modalOverlay.addEventListener('click', (e) => {
                    if (e.target === modalOverlay) {
                        closeModal();
                    }
                });

                // Cerrar modal con ESC
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        closeModal();
                    }
                });
            }

            // Función para cerrar modal
            function closeModal() {
                const modalOverlay = document.getElementById('modal-overlay');
                if (modalOverlay) {
                    modalOverlay.remove();
                    document.body.classList.remove('overflow-hidden');
                }
            }

            // Función para mostrar mensaje de notificación
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className =
                    `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transition-all transform translate-x-0
                                                                                                                                                                                ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;

                notification.innerHTML =
                    `
                                                                                                                                                                                <div class="flex items-center">
                                                                                                                                                                                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-3"></i>
                                                                                                                                                                                    <p>${message}</p>
                                                                                                                                                                                </div>
                                                                                                                                                                            `;

                document.body.appendChild(notification);

                // Animación de entrada
                setTimeout(() => {
                    notification.classList.add('translate-y-2');
                }, 100);

                // Remover después de 3 segundos
                setTimeout(() => {
                    notification.classList.add('opacity-0');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 3000);
            }

            // Función para manejar errores de la API
            function handleApiError(error, defaultMessage = 'Ha ocurrido un error') {
                if (error.response && error.response.status === 401) {
                    // Error de autenticación, redirigir al login
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                    return;
                }

                // Mostrar mensaje de error
                const message = error.message || defaultMessage;
                showNotification(message, 'error');
            }
        </script>
        @vite('resources/js/views/Usuarios/index.js')
    @endpush
@endsection
