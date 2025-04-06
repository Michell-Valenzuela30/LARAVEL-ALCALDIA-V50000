<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --success-color: #10b981;
            --light-bg: #f8fafc;
            --dark-bg: #1e293b;
            --light-card: #ffffff;
            --dark-card: #0f172a;
            --light-text: #334155;
            --dark-text: #e2e8f0;
            --light-border: #e2e8f0;
            --dark-border: #334155;
        }

        body {
            background-color: var(--light-bg);
            color: var(--light-text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            transition: all 0.3s ease;
        }

        body.dark-mode {
            background-color: var(--dark-bg);
            color: var(--dark-text);
        }

        .install-container {
            max-width: 900px;
            margin: 40px auto;
            background: var(--light-card);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        body.dark-mode .install-container {
            background: var(--dark-card);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .install-header {
            background: var(--primary-color);
            color: white;
            padding: 25px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-container img {
            height: 40px;
            margin-right: 15px;
        }

        .theme-toggle {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .install-steps {
            display: flex;
            border-bottom: 1px solid var(--light-border);
            padding: 0;
            transition: all 0.3s ease;
        }

        body.dark-mode .install-steps {
            border-bottom: 1px solid var(--dark-border);
        }

        .install-step {
            flex: 1;
            text-align: center;
            padding: 20px 10px;
            position: relative;
            font-weight: 500;
            color: #94a3b8;
            transition: all 0.3s ease;
        }

        .install-step::before {
            content: '';
            position: absolute;
            width: 24px;
            height: 24px;
            background: #e2e8f0;
            border-radius: 50%;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            transition: all 0.3s ease;
        }

        body.dark-mode .install-step::before {
            background: #334155;
        }

        .install-step::after {
            content: '';
            position: absolute;
            right: 0;
            left: 0;
            top: 0;
            height: 3px;
            background: #e2e8f0;
            z-index: 1;
            transition: all 0.3s ease;
        }

        body.dark-mode .install-step::after {
            background: #334155;
        }

        .install-step:first-child::after {
            left: 50%;
        }

        .install-step:last-child::after {
            right: 50%;
        }

        .install-step.active {
            font-weight: 600;
            color: var(--primary-color);
        }

        .install-step.active::before {
            background: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
        }

        .install-step.completed {
            color: var(--success-color);
        }

        .install-step.completed::before {
            background: var(--success-color);
        }

        .install-step.completed::after {
            background: var(--success-color);
        }

        .install-content {
            padding: 40px 30px;
        }

        .install-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            border-top: 1px solid var(--light-border);
            transition: all 0.3s ease;
        }

        body.dark-mode .install-footer {
            border-top: 1px solid var(--dark-border);
        }

        .developer-info {
            display: flex;
            flex-direction: column;
            font-size: 0.875rem;
        }

        .developer-info a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .developer-info a:hover {
            color: var(--primary-dark);
        }

        .version-info {
            color: #94a3b8;
            font-size: 0.75rem;
            margin-top: 2px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .btn-primary i {
            margin-right: 8px;
        }

        .environment-card {
            border-radius: 12px;
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        body.dark-mode .environment-card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .environment-card .card-header {
            background-color: rgba(99, 102, 241, 0.1);
            border-bottom: none;
            padding: 16px 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        body.dark-mode .environment-card .card-header {
            background-color: rgba(99, 102, 241, 0.2);
        }

        .environment-card .card-header img {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }

        .environment-card .card-body {
            padding: 20px;
        }

        .environment-card ul {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .environment-card li {
            margin-bottom: 8px;
        }

        .environment-card li:last-child {
            margin-bottom: 0;
        }

        .environment-card code {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 0.85em;
            transition: all 0.3s ease;
        }

        body.dark-mode .environment-card code {
            background-color: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
        }

        .welcome-heading {
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(90deg, var(--primary-color), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        body.dark-mode .welcome-heading {
            background: linear-gradient(90deg, #a5b4fc, #c4b5fd);
            -webkit-background-clip: text;
            background-clip: text;
        }

        .note-container {
            background-color: rgba(99, 102, 241, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        body.dark-mode .note-container {
            background-color: rgba(99, 102, 241, 0.1);
        }

        .note-heading {
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .note-heading i {
            color: var(--primary-color);
            margin-right: 8px;
        }

        .copy-token {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .copy-token:hover {
            transform: scale(1.1);
            color: var(--primary-color);
        }
    </style>
</head>

<body class="{{ session('theme', 'dark') }}">
    <div class="install-container">
        <div class="install-header">
            <div class="logo-container">
                <img src="{{ asset('installation/logo/logo_for_' . session('theme', 'light') . '.svg') }}"
                    alt="{{ config('app.name') }} Logo" class="logo">
                <div>
                    <h2 class="mb-0">Asistente de Instalación</h2>
                    <p class="mb-0">{{ config('app.name', 'Laravel') }}</p>
                </div>
            </div>
            <button id="themeToggle" class="theme-toggle" aria-label="Cambiar tema">
                <i class="fas fa-moon"></i>
            </button>
        </div>

        <div class="install-steps">
            <div
                class="install-step {{ request()->routeIs('installation.welcome') ? 'active' : (request()->routeIs('installation.requirements', 'installation.database', 'installation.user', 'installation.finish') ? 'completed' : '') }}">
                Bienvenida
            </div>
            <div
                class="install-step {{ request()->routeIs('installation.requirements') ? 'active' : (request()->routeIs('installation.database', 'installation.user', 'installation.finish') ? 'completed' : '') }}">
                Requisitos
            </div>
            <div
                class="install-step {{ request()->routeIs('installation.database') ? 'active' : (request()->routeIs('installation.user', 'installation.finish') ? 'completed' : '') }}">
                Base de Datos
            </div>
            <div
                class="install-step {{ request()->routeIs('installation.user') ? 'active' : (request()->routeIs('installation.finish') ? 'completed' : '') }}">
                Usuario Root
            </div>
            <div class="install-step {{ request()->routeIs('installation.finish') ? 'active' : '' }}">
                Finalizar
            </div>
        </div>

        <div class="install-content">
            @yield('content')
        </div>

        <div class="install-footer">
            <div class="developer-info">
                <a href="https://instagram.com/dansware03" target="_blank">Desarrollado por Dansware Developer</a>
                <span class="version-info">Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span>
            </div>
            @yield('footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeToggle = document.getElementById('themeToggle');
            const body = document.body;
            const logoImg = document.querySelector('.logo');

            themeToggle.addEventListener('click', function () {
                if (body.classList.contains('dark-mode')) {
                    body.classList.remove('dark-mode');
                    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                    logoImg.src = "{{ asset('installation/logo/logo_for_light.svg') }}";
                    setThemePreference('light');
                } else {
                    body.classList.add('dark-mode');
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                    logoImg.src = "{{ asset('installation/logo/logo_for_dark.svg') }}";
                    setThemePreference('dark');
                }
            });

            // Check system preference for dark mode
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                body.classList.add('dark-mode');
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                logoImg.src = "{{ asset('installation/logo/logo_for_dark.svg') }}";
                setThemePreference('dark');
            }

            // Listen for changes in system preference
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (e.matches) {
                    body.classList.add('dark-mode');
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                    logoImg.src = "{{ asset('installation/logo/logo_for_dark.svg') }}";
                    setThemePreference('dark');
                } else {
                    body.classList.remove('dark-mode');
                    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                    logoImg.src = "{{ asset('installation/logo/logo_for_light.svg') }}";
                    setThemePreference('light');
                }
            });

            function setThemePreference(theme) {
                fetch("{{ route('installation.setTheme') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ theme: theme })
                });
            }

            // Detectar el SO para mostrar instrucciones relevantes
            const isWindows = navigator.platform.indexOf('Win') > -1;
            const linuxSection = document.getElementById('linux-instructions');
            const windowsSection = document.getElementById('windows-instructions');

            if (linuxSection && windowsSection) {
                if (isWindows) {
                    // Si es Windows, mostrar instrucciones de Windows y Linux
                    windowsSection.classList.remove('d-none');
                } else {
                    // Si es Linux, mostrar ambas secciones pero:
                    // - Conservar las instrucciones de Linux
                    // - Reemplazar el contenido de Windows por una imagen ampliada del icono cPanel
                    linuxSection.classList.remove('d-none');
                    windowsSection.classList.remove('d-none');
                    windowsSection.innerHTML = `
    <div class="d-flex justify-content-center align-items-center h-100">
        <img src="{{ asset('installation/cpanel.svg') }}" alt="cPanel Icon" class="img-fluid">
    </div>
`;
                }
            }
        });
    </script>
</body>

</html>
