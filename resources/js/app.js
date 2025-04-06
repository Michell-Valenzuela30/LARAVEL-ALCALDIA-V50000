import "./bootstrap";

// Inicialización del tema al cargar la página
document.addEventListener("DOMContentLoaded", () => {
    const html = document.documentElement;
    const savedTheme = localStorage.getItem("theme");
    const prefersDark = window.matchMedia(
        "(prefers-color-scheme: dark)"
    ).matches;

    if (savedTheme) {
        // Aplica el tema guardado
        html.classList.toggle("dark", savedTheme === "dark");
    } else if (prefersDark) {
        // Si no hay tema guardado, usa la preferencia del sistema
        html.classList.add("dark");
        localStorage.setItem("theme", "dark");
    }
});

// Función única para hacer toggle del tema
const toggleTheme = () => {
    const html = document.documentElement;
    html.classList.toggle("dark");
    const isDark = html.classList.contains("dark");
    localStorage.setItem("theme", isDark ? "dark" : "light");

    // Si deseas actualizar el tema en el servidor, se usa esta sección.
    // Asegúrate de que en el layout exista la ruta en un meta tag, por ejemplo:
    // <meta name="theme-update-url" content="{{ route('theme.set') }}">
    const themeUpdateUrlMeta = document.querySelector(
        "meta[name='theme-update-url']"
    );
    if (themeUpdateUrlMeta) {
        fetch(themeUpdateUrlMeta.getAttribute("content"), {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                // Si usas token de autorización, puedes incluirlo:
                Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            },
            body: JSON.stringify({ theme: isDark ? "dark" : "light" }),
        }).catch((err) =>
            console.error("Error al actualizar el tema en el servidor:", err)
        );
    }
};

// Asigna el evento de toggle a todos los botones que puedan cambiar el tema
const themeToggleElements = document.querySelectorAll(
    "#theme-toggle, #theme-toggle-mobile, #theme-toggle-login, #toggle-theme"
);
themeToggleElements.forEach((element) => {
    element.addEventListener("click", toggleTheme);
});
