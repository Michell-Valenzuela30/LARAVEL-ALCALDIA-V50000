import { fetchWithAuth } from '../../api.js';

document.addEventListener('DOMContentLoaded', async () => {
    try {
        // Obtener datos de usuario con la nueva función de autenticación
        const data = await fetchWithAuth('/api/usuarios');

        if (data) {
            // Actualizar contadores
            document.getElementById('total-usuarios').textContent = data.total || data.data?.length || 0;
            document.getElementById('nuevos-usuarios').textContent = '0'; // Esto podría mejorarse filtrando por fecha
        }
    } catch (error) {
        console.error('Error al cargar datos del dashboard:', error);
    }
});
