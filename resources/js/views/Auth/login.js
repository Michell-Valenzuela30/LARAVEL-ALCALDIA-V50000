document.addEventListener("DOMContentLoaded", () => {
    // Formulario de login
    const loginForm = document.getElementById("login-form");
    const loginSpinner = document.getElementById("login-spinner");
    const loginError = document.getElementById("login-error");

    loginForm?.addEventListener("submit", async (e) => {
        e.preventDefault();

        loginSpinner.classList.remove("hidden");
        loginError.classList.add("hidden");

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        try {
            const response = await fetch("/api/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({
                    email,
                    password,
                    device_name: navigator.userAgent || "Browser",
                }),
            });

            const data = await response.json();

            if (response.ok && data.token) {
                // Guardar token en localStorage
                localStorage.setItem("auth_token", data.token);

                // Redirigir al dashboard
                window.location.href = "/dashboard";
            } else {
                // Mostrar error
                loginError.textContent =
                    data.message ||
                    "Credenciales incorrectas. Intente nuevamente.";
                loginError.classList.remove("hidden");
            }
        } catch (error) {
            console.error("Error de login:", error);
            loginError.textContent =
                "Error al conectar con el servidor. Intente nuevamente.";
            loginError.classList.remove("hidden");
        } finally {
            loginSpinner.classList.add("hidden");
        }
    });
});
