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
