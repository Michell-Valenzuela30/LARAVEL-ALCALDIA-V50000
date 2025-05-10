# 📌 UPDATE.md - 10 De Mayo 2025 - Vista de Autoridades

Implementación de la interfaz de administración de autoridades, incluyendo:

* **Rutas protegidas** con middleware `role:root,admin` para listar, crear, ver, eliminar y activar autoridades.
* **Vista principal** (`index.blade.php`) con DataTables, modal de creación/edición y visualización de autoridades activas.
* **Controles en la interfaz**: botones para editar, activar (si está inactiva) y eliminar.
* **Soporte de JS** con SweetAlert2 para confirmaciones y validaciones.
* **Modificación del menú lateral y navegación móvil** con enlaces hacia la nueva vista.

# 📌 UPDATE.md - 10 De Mayo 2025 - Vista de Catastro

Se ha implementado la **Vista principal** del módulo de Catastro en `resources/views/admin/catastro/index.blade.php`:

**Detalles de la actualización:**

* Se creó la vista principal de Catastro con un listado dinámico de cédulas catastrales.
* Se añadieron botones y modales para crear, editar y eliminar cédulas usando DataTables y SweetAlert2.
* Se definieron componentes Blade (`modals` y `scripts`) para organizar el marcado y los comportamientos JS.
* La tabla incluye columnas: N° de Cédula, N° de Expediente, Propietario, Tipo de Inmueble, Ámbito, Fecha de Expedición y Acciones.
* Los scripts gestionan las peticiones AJAX a las rutas de los controladores ya implementados.

Con esta vista, la interfaz administrativa de Catastro está lista para consumir la API y ofrecer una experiencia de usuario fluida.

# 📌 UPDATE.md - 05 De Mayo 2025 - Controladores del Sistema de Catastro

Se implementa cuatro controladores principales para gestionar las funcionalidades del Sistema de Catastro:

---

## 1. CedulaCatastralController

**Funcionalidades implementadas:**

* **index()**: Lista todas las cédulas catastrales con sus relaciones (`propietario`, `linderos`, `documentoLegal`).
* **store(Request \$request)**: Valida y crea o actualiza una cédula catastral, incluyendo:

  * Gestión de datos del propietario (creación o asociación según cédula).
  * Creación o actualización de linderos.
  * Creación o actualización de documento legal (si aplica).
  * Manejo de transacciones con `DB::beginTransaction()` y `DB::commit()` / `DB::rollBack()`.
* **show(\$id)**: Retorna los detalles de una cédula específica con sus relaciones.
* **destroy(\$id)**: Elimina una cédula catastral verificando:

  * Ausencia de solvencias municipales asociadas.
  * Eliminación en cascada de linderos y documentos legales relacionados.
* **buscar(Request \$request)**: Busca cédulas por número de cédula o expediente, devolviendo coincidencias con relaciones.

---

## 2. SolvenciaMunicipalController

**Funcionalidades implementadas:**

* **index()**: Lista todas las solvencias municipales con sus relaciones (`propietario`, `cedulaCatastral`).
* **store(Request \$request)**: Valida y crea o actualiza una solvencia municipal, incluyendo:

  * Validación de existencia de la cédula catastral asociada.
  * Gestión de vigencias y fechas.
  * Transacciones para integridad.
* **show(\$id)**: Retorna los detalles de una solvencia específica con relaciones.
* **destroy(\$id)**: Elimina una solvencia municipal de forma segura.
* **generarPdf(\$id)**: Genera (o prepara) la vista para exportar la solvencia a PDF, cargando también la autoridad activa.
* **buscarCedula(Request \$request)**: Busca una cédula catastral por número o expediente para facilitar la emisión de una solvencia.

---

## 3. PropietarioController

**Funcionalidades implementadas:**

* **index()**: Lista todos los propietarios.
* **store(Request \$request)**: Valida y crea o actualiza un propietario, asegurando unicidad de la cédula.
* **show(\$id)**: Retorna los detalles de un propietario con sus cédulas catastrales y solvencias municipales.
* **destroy(\$id)**: Elimina un propietario comprobando que no existan registros asociados.
* **buscar(Request \$request)**: Busca propietarios por nombre o cédula.

---

## 4. AutoridadController

**Funcionalidades implementadas:**

* **index()**: Lista todas las autoridades y marca la autoridad activa.
* **store(Request \$request)**: Valida y crea o actualiza una autoridad, gestionando el atributo `activo`:

  * Desactiva automáticamente otras autoridades si se marca como activa.
* **show(\$id)**: Retorna los detalles de una autoridad específica.
* **destroy(\$id)**: Elimina una autoridad comprobando:

  * Que no sea la única existente.
  * Que, si es activa, se asigne la activación a otra autoridad.
* **activar(\$id)**: Establece una autoridad como la activa, desactivando previamente las demás.

---

# 📌 UPDATE.md - 05 De Mayo 2025 - Estructura de Base de Datos Mejorada

Se implemeto:
1. Cédulas Catastrales
2. Solvencias Municipales Tipo A
3. Información de Autoridades


## Estructura de Base de Datos

### 1. Normalización de la base de datos

- **Separación de entidades**: He creado tablas independientes para cada entidad principal (propietarios, linderos, documentos legales, cédulas catastrales, solvencias municipales y autoridades).
- **Eliminación de redundancia**: Los datos del propietario ahora se almacenan una sola vez en la tabla `propietarios` y se referencian mediante claves foráneas.

### 2. Mejoras en la estructura de datos

- **Tipos de datos adecuados**: He utilizado tipos de datos específicos como `decimal` para cantidades, `enum` para opciones predefinidas y `date` para fechas.
- **Campos obligatorios vs opcionales**: He definido claramente qué campos son obligatorios y cuáles son opcionales con `nullable()`.
- **Claves únicas**: He añadido restricciones de unicidad a campos importantes como números de expediente, cédula catastral, etc.

### 3. Relaciones entre tablas

- He establecido relaciones claras entre las tablas utilizando claves foráneas.
- Cada modelo incluye métodos para acceder a sus relaciones (hasOne, hasMany, belongsTo).

### 4. Modelo de datos completo

- **Propietarios**: Almacena información de los propietarios de inmuebles.
- **Linderos**: Contiene los linderos y medidas de los terrenos.
- **Documentos Legales**: Almacena información sobre documentos legales asociados.
- **Cédulas Catastrales**: La tabla principal para las cédulas catastrales.
- **Solvencias Municipales**: Para gestionar las solvencias municipales tipo A.
- **Autoridades**: Almacena información sobre las autoridades municipales.


Esta estructura te permitirá un manejo más eficiente y organizado de la información del catastro, con menos redundancia y mejor integridad de datos.
