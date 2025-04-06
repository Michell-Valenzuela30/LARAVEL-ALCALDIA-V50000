// Inicializar tema según localStorage al cargar
document.addEventListener('DOMContentLoaded', () => {

    // Añadir animación al cargar la página
    document.querySelectorAll('.animate-fadeIn').forEach(el => {
        el.style.opacity = '0';
        setTimeout(() => {
            el.style.opacity = '1';
        }, 100);
    });
});
