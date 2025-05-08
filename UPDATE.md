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
