export async function fetchWithAuth(url, options = {}) {
    const token = localStorage.getItem('auth_token');

    if (!token) {
        console.error('No hay token disponible. Redirigiendo al login.');
        window.location.href = '/login';
        return null;
    }

    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
        ...options.headers
    };

    try {
        const response = await fetch(url, { ...options, headers, credentials: 'include' });

        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            console.error("Error: Servidor devolvió HTML en lugar de JSON.");
            const textResponse = await response.text();
            console.error("Respuesta HTML:", textResponse);
            throw new Error("El servidor devolvió HTML en lugar de JSON.");
        }

        const data = await response.json();

        if (response.status === 401) {
            console.warn('Token inválido o expirado. Redirigiendo al login.');
            localStorage.removeItem('auth_token');
            window.location.href = '/login';
        }

        return data;
    } catch (error) {
        console.error("Error en la solicitud API:", error);
        return null;
    }
}
