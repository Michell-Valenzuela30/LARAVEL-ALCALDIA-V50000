    // Función de búsqueda
    function searchUsers(query) {
        if (!query || query.trim() === "") {
            filteredUsers = [...usersList];
        } else {
            query = query.toLowerCase().trim();
            filteredUsers = usersList.filter(
                (user) =>
                    user.name.toLowerCase().includes(query) ||
                    user.email.toLowerCase().includes(query) ||
                    (user.role && user.role.toLowerCase().includes(query))
            );
        }

        renderUsers(filteredUsers);
    }

    // Función para ocultar la opción "root"
    function hideRootRoleOption() {
        const rootOption = document.querySelector(
            '#user-role option[value="root"]'
        );
        if (rootOption) {
            rootOption.remove();
        }
    }

    // Función para activar (mostrar) la opción "root"
    function showRootRoleOption() {
        const select = document.getElementById("user-role");
        // Verifica si la opción ya existe
        let rootOption = select.querySelector('option[value="root"]');
        if (!rootOption) {
            // Crea la opción "root"
            rootOption = document.createElement("option");
            rootOption.value = "root";
            rootOption.textContent = "Root";
            // Inserta la opción en la posición deseada
            // Suponiendo que quieres el orden: Usuario, Administrador, Root
            const adminOption = select.querySelector('option[value="admin"]');
            if (adminOption && adminOption.nextElementSibling) {
                adminOption.parentNode.insertBefore(
                    rootOption,
                    adminOption.nextElementSibling
                );
            } else {
                // Si no existe la opción "admin" o no hay elemento siguiente, se agrega al final
                select.appendChild(rootOption);
            }
        }
    }

    // Exportar usuarios a CSV
    function exportUsersToCSV() {
        // Obtener todos los usuarios (sin paginación)
        fetch("/api/usuarios/export", {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
                Accept: "application/json",
            },
        })
            .then((response) => response.blob())
            .then((blob) => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.style.display = "none";
                a.href = url;
                a.download = "usuarios.csv";
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch((error) => {
                console.error("Error al exportar usuarios:", error);
                showNotification("Error al exportar usuarios", "error");
            });
    }

    // Añadir botón de exportar a CSV si se necesita
    function addExportButton() {
        const actionsContainer = document.querySelector(
            ".flex.flex-col.sm\\:flex-row.gap-3"
        );
        if (actionsContainer) {
            const exportButton = document.createElement("button");
            exportButton.className = "btn btn-secondary";
            exportButton.innerHTML =
                '<i class="fas fa-download mr-2"></i> Exportar CSV';
            exportButton.addEventListener("click", exportUsersToCSV);
            actionsContainer.appendChild(exportButton);
        }
    }
