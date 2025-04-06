import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/views/Admin/dashboard.js",
                "resources/js/views/Auth/login.js",
                "resources/js/views/Errors/acceso-restringido.js",
                "resources/js/views/Installation/finish.js",
                "resources/js/views/Installation/user.js",
                "resources/js/views/layouts/adminLayout.js",
                "resources/js/views/Profile/index.js",
                "resources/js/views/Usuarios/index.js",
            ],
            refresh: true,
        }),
    ],
});
