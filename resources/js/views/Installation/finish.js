document.addEventListener("DOMContentLoaded", () => {
    function copyToClipboard(text) {
        navigator.clipboard
            .writeText(text)
            .then(() => {
                // Cambiar temporalmente el icono para feedback visual
                const btn = document.querySelector(".copy-token");
                const icon = btn.querySelector("i");
                icon.classList.remove("fa-copy");
                icon.classList.add("fa-check");

                // Añadir un tooltip temporal
                btn.setAttribute("data-bs-original-title", "¡Copiado!");
                const tooltip = new bootstrap.Tooltip(btn);
                tooltip.show();

                // Restaurar el icono después de 2 segundos
                setTimeout(() => {
                    icon.classList.remove("fa-check");
                    icon.classList.add("fa-copy");
                    tooltip.hide();
                    btn.setAttribute(
                        "data-bs-original-title",
                        "Copiar al portapapeles"
                    );
                }, 2000);
            })
            .catch((err) => {
                console.error("Error al copiar:", err);
                alert(
                    "Error al copiar el token. Por favor cópialo manualmente."
                );
            });
    }
});
