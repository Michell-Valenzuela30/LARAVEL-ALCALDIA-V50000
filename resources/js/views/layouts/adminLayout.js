// Manejar menú de usuario
document
    .getElementById("user-menu-button")
    ?.addEventListener("click", function () {
        document.getElementById("user-dropdown").classList.toggle("hidden");
    });

// Cerrar menú de usuario al hacer click fuera
document.addEventListener("click", function (event) {
    const userMenu = document.getElementById("user-dropdown");
    const userMenuButton = document.getElementById("user-menu-button");

    if (
        userMenu &&
        userMenuButton &&
        !userMenuButton.contains(event.target) &&
        !userMenu.contains(event.target)
    ) {
        userMenu.classList.add("hidden");
    }
});

// Toggle sidebar en móvil
document.getElementById("menu-toggle")?.addEventListener("click", function () {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("hidden");
    sidebar.classList.toggle("absolute");
    sidebar.classList.toggle("z-20");
    sidebar.classList.toggle("h-screen");
    sidebar.classList.toggle("w-64");
});

// Funciones para cerrar sesión
const logoutFn = async () => {
    const token = localStorage.getItem("auth_token");
    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const response = await fetch("/api/logout", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                Authorization: `Bearer ${token}`,
            },
        });

        // Leer respuesta sin convertir directamente a JSON
        const text = await response.text();

        // Intentamos convertir a JSON solo si la respuesta es válida
        try {
            const data = JSON.parse(text);
            if (response.ok) {
                localStorage.removeItem("auth_token");
                window.location.href = "/login";
            } else {
                console.error("Error al cerrar sesión:", data);
            }
        } catch (jsonError) {
            console.error("La respuesta no es un JSON válido:", text);
        }
    } catch (error) {
        console.error("Error en la solicitud de logout:", error);
    }
};

// Asignar evento a todos los botones de logout
document.getElementById("logout-btn")?.addEventListener("click", logoutFn);
document
    .getElementById("logout-dropdown-btn")
    ?.addEventListener("click", logoutFn);
document
    .getElementById("logout-mobile-btn")
    ?.addEventListener("click", logoutFn);

// Sistema de modales
window.openModal = function (content) {
    document.getElementById("modal-content").innerHTML = content;
    document.getElementById("modal-base").classList.remove("hidden");
};

window.closeModal = function () {
    document.getElementById("modal-base").classList.add("hidden");
};

// Cerrar modal haciendo click fuera
document.getElementById("modal-base")?.addEventListener("click", function (e) {
    if (e.target === this) {
        window.closeModal();
    }
});

// Script para toggle del Sidebar y animación del ícono
const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');

        // Actualizar el ícono del botón (cambia de 'fa-bars' a 'fa-times')
        const icon = sidebarToggle.querySelector('i');
        if (sidebar.classList.contains('-translate-x-full')) {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        } else {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        }
    });
