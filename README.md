# Templete System - Laravel 10

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://semver.org)

![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?logo=php&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?logo=composer&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-3-003B57?logo=sqlite&logoColor=white)

Este proyecto implementa un asistente de instalación interactivo para una aplicación Laravel 10, permitiendo configurar fácilmente una nueva instancia con base de datos (MySQL o SQLite), usuario administrador y configuraciones básicas del sistema.

## Actualizaciones

Puedes ver todos los cambios recientes en el proyecto en el archivo [UPDATE.md](UPDATE.md)


---

## Características Principales
---

## Nuevas Mejoras y Funcionalidades

---

## Requisitos del Sistema

- 🐘 **PHP >= 8.1**
- 📦 **Composer**
- 🗃️ **MySQL 5.7+** o **SQLite 3** (según preferencia)
- 🔌 **Extensiones PHP:** BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML.
- 📂 **Permisos de escritura** en directorios `storage` y `bootstrap/cache`.
- 🔐 **Laravel Sanctum** para autenticación de API
---

## Instalación

1. **Clone el repositorio:**
   ```bash
   git clone https://github.com/Dansware03/system_alcaldia_for_laravel_10.git
   cd system_alcaldia_for_laravel_10
   ```

2. **Instale las dependencias:**
   ```bash
   composer install && npm install && npm run build
   ```

3. **Cree una copia del archivo de entorno:**
   ```bash
   cp .env.example .env
   ```

4. **Genere la clave de aplicación:**
   ```bash
   php artisan key:generate
   ```

5. **Acceda al asistente de instalación:**
   ```bash
   php artisan serve
   ```
   Luego visita: [http://localhost:8000/install](http://localhost:8000/install)

---

## Flujo de Instalación

El asistente de instalación guía al usuario a través de los siguientes pasos:

1. **Bienvenida:** Introducción al asistente de instalación.
2. **Verificación de Requisitos:** Comprueba que el servidor cumpla con todos los requisitos.
3. **Configuración de Base de Datos:** Elección entre MySQL o SQLite y configuración de conexión, con opción de probar la conexión real.
4. **Creación de Usuario Root:** Establecimiento de credenciales para el administrador principal.
5. **Instalación:** Ejecución de migraciones, seeders y configuraciones finales.
6. **Finalización:** Confirmación de instalación exitosa, visualización del token y detalles del entorno.

---

## Estructura del Proyecto

```
app/
├── Http/
│   ├── Controllers/
│   │   └── InstallationController.php   # Controlador principal de instalación
    ├── API/
│   │   │   ├── AuthController.php     # Controlador de autenticación
│   │   │   └── UserController.php     # Controlador de gestión de usuarios
│   └── Middleware/
│       └── InstallationMiddleware.php     # Middleware para gestionar estado de instalación
│       └── CheckRole.php              # Middleware para verificación de roles
├── ...
resources/
├── views/
│   └── installation/                      # Vistas del asistente de instalación
│       ├── layout.blade.php               # Layout principal del asistente
│       ├── welcome.blade.php              # Página de bienvenida
│       ├── requirements.blade.php         # Verificación de requisitos (diseño modernizado)
│       ├── database.blade.php             # Configuración de base de datos (formulario mejorado)
│       ├── user.blade.php                 # Creación de usuario root (vista rediseñada)
│       └── finish.blade.php               # Confirmación de instalación con token y entorno
routes/
├── web.php                                # Rutas web incluyendo rutas de instalación y test de conexión
├── api.php                                # Rutas de API protegidas por autenticación
├── installation.php                       # Rutas de instalación
database/
├── migrations/                            # Migraciones de la base de datos
└── seeders/                               # Seeders para datos iniciales
```

---

## API REST

El sistema incluye una API REST protegida por autenticación basada en tokens usando Laravel Sanctum. Tras la instalación, el usuario root recibe un token de API que puede utilizarse para realizar solicitudes autenticadas.

### Endpoints Principales

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| POST | `/api/registro` | Registro de nuevos usuarios | No |
| POST | `/api/login` | Inicio de sesión | No |
| POST | `/api/logout` | Cerrar sesión | Sí |
| GET | `/api/perfil` | Obtener información del usuario autenticado | Sí |
| CRUD | `/api/usuarios` | Gestión de usuarios (solo root/admin) | Sí |

### Ejemplos de Uso

#### Registro de Usuario
```bash
curl -X POST http://localhost:8000/api/registro \
  -H 'Content-Type: application/json' \
  -d '{
    "name": "Nombre Usuario",
    "email": "usuario@ejemplo.com",
    "password": "contraseña123",
    "password_confirmation": "contraseña123"
  }'
```

#### Inicio de Sesión
```bash
curl -X POST http://localhost:8000/api/login \
  -H 'Content-Type: application/json' \
  -d '{
    "email": "usuario@ejemplo.com",
    "password": "contraseña123",
    "device_name": "Postman"
  }'
```

#### Obtener Perfil (Requiere Token)
```bash
curl -X GET http://localhost:8000/api/perfil \
  -H 'Authorization: Bearer [TOKEN_OBTENIDO_EN_LOGIN]'
```

#### Crear Usuario (Solo para Root/Admin)
```bash
curl -X POST http://localhost:8000/api/usuarios \
  -H 'Authorization: Bearer [TOKEN_ROOT_O_ADMIN]' \
  -H 'Content-Type: application/json' \
  -d '{
    "name": "Nuevo Usuario",
    "email": "nuevo@ejemplo.com",
    "password": "contraseña123",
    "role": "user"
  }'
```

### Notas de Seguridad
- Todos los endpoints protegidos requieren un token válido
- Los usuarios con rol 'root' o 'admin' tienen acceso al CRUD completo de usuarios
- Los tokens tienen una duración limitada
```

---

## Seguridad

- El sistema implementa protección CSRF para todos los formularios.
- La autenticación API utiliza tokens con tiempo de expiración.
- Las contraseñas se almacenan con hash seguro mediante bcrypt.
- El acceso al asistente de instalación se bloquea automáticamente tras completar la instalación.

---

## Licencia

Este proyecto está licenciado bajo [MIT](https://choosealicense.com/licenses/mit/)
