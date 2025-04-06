@extends('installation.layout')

@section('content')
    <div class="mb-4">
        <h3 class="welcome-heading">Configuración de Base de Datos</h3>
        <p class="lead">Configura los parámetros de conexión a la base de datos de tu aplicación.</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 d-flex align-items-center shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
            <div>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form id="database_form" method="POST" action="{{ route('installation.database.save') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold">Tipo de Base de Datos</label>
                    <div class="d-flex gap-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="database_type" id="type_mysql" value="mysql"
                                checked>
                            <label class="form-check-label d-flex align-items-center" for="type_mysql">
                                <i class="fas fa-database text-primary me-2"></i> MySQL
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="database_type" id="type_sqlite"
                                value="sqlite">
                            <label class="form-check-label d-flex align-items-center" for="type_sqlite">
                                <i class="fas fa-file-alt text-primary me-2"></i> SQLite
                            </label>
                        </div>
                    </div>
                </div>

                <div id="mysql_fields">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="database_host" class="form-label">Host</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-server"></i>
                                </span>
                                <input type="text" class="form-control" id="database_host" name="database_host"
                                    value="127.0.0.1">
                            </div>
                            @error('database_host')
                                <div class="text-danger mt-1 small">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="database_port" class="form-label">Puerto</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-plug"></i>
                                </span>
                                <input type="text" class="form-control" id="database_port" name="database_port"
                                    value="3306">
                            </div>
                            @error('database_port')
                                <div class="text-danger mt-1 small">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="database_name" class="form-label">Nombre de la Base de Datos</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-database"></i>
                            </span>
                            <input type="text" class="form-control" id="database_name" name="database_name" value="laravel">
                        </div>
                        @error('database_name')
                            <div class="text-danger mt-1 small">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="database_user" class="form-label">Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" id="database_user" name="database_user" value="root">
                        </div>
                        @error('database_user')
                            <div class="text-danger mt-1 small">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="database_password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="password" class="form-control" id="database_password" name="database_password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Botón de test de conexión y contenedor para el resultado -->
                    <div class="mb-0">
                        <button type="button" id="testConnection" class="btn btn-outline-primary">
                            <i class="fas fa-vial me-2"></i> Probar Conexión
                        </button>
                        <div id="connectionResult" class="mt-2" style="display: none;"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mysqlRadio = document.getElementById('type_mysql');
            const sqliteRadio = document.getElementById('type_sqlite');
            const mysqlFields = document.getElementById('mysql_fields');

            // Toggle database fields visibility based on selected database type
            function toggleFields() {
                if (mysqlRadio.checked) {
                    mysqlFields.style.display = 'block';
                } else {
                    mysqlFields.style.display = 'none';
                }
            }

            mysqlRadio.addEventListener('change', toggleFields);
            sqliteRadio.addEventListener('change', toggleFields);

            toggleFields();

            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('database_password');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                const icon = this.querySelector('i');
                if (type === 'password') {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });

            // Test database connection
            const testConnectionBtn = document.getElementById('testConnection');
            const connectionResult = document.getElementById('connectionResult');

            testConnectionBtn.addEventListener('click', function () {
                const host = document.getElementById('database_host').value;
                const port = document.getElementById('database_port').value;
                const name = document.getElementById('database_name').value;
                const user = document.getElementById('database_user').value;
                const password = document.getElementById('database_password').value;

                connectionResult.innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Probando conexión...';
                connectionResult.style.display = 'block';

                fetch("{{ route('installation.testConnection') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        database_host: host,
                        database_port: port,
                        database_name: name,
                        database_user: user,
                        database_password: password
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            connectionResult.innerHTML = '<div class="alert alert-success py-2 mb-0"><i class="fas fa-check-circle me-2"></i>' + data.message + '</div>';
                        } else {
                            connectionResult.innerHTML = '<div class="alert alert-danger py-2 mb-0"><i class="fas fa-times-circle me-2"></i>' + data.message + '</div>';
                        }
                    })
                    .catch(error => {
                        connectionResult.innerHTML = '<div class="alert alert-danger py-2 mb-0"><i class="fas fa-times-circle me-2"></i> Error al probar la conexión.</div>';
                    });
            });
        });
    </script>
@endsection

@section('footer')
    <a href="{{ route('installation.requirements') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i> Anterior
    </a>
    <button form="database_form" type="submit" class="btn btn-primary">
        Configurar Usuario Root <i class="fas fa-arrow-right ms-2"></i>
    </button>
@endsection
