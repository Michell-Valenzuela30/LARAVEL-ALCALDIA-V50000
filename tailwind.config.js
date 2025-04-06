/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                primary: {
                    light: "#df0000",
                    DEFAULT: "#d10c0c",
                    dark: "#ff0000",
                },
                secondary: {
                    light: "#f3f4f6",
                    DEFAULT: "#e5e7eb",
                    dark: "#d1d5db",
                },
            },
        },
    },
    plugins: [],
};
