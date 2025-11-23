
# Sistema de Autenticación con SQLite y Hash Seguro

## Resumen
- Proyecto sencillo en PHP que implementa registro e inicio de sesión usando PDO con SQLite.
- Las contraseñas se almacenan de forma segura mediante `password_hash()` y se verifican con `password_verify()`.

## Qué se solicitaba (requisitos principales)
- Crear la base de datos y la tabla de usuarios.
- Permitir registro de usuarios con almacenamiento seguro de contraseñas.
- Permitir inicio de sesión que verifique el hash y gestione la sesión del usuario.
- Usar PDO y sentencias preparadas para prevenir inyección SQL.

## Estado actual — qué se ha implementado
- **Creación de BD y tabla**: `crear_tabla.php` crea `database/usuarios.db` y la tabla `usuarios` (id, usuario UNIQUE, password).
- **Conexión robusta**: `conexion.php` devuelve un objeto PDO y crea la tabla si no existe (evita error "no such table").
- **Registro (`registro.php`)**:
	- Hash de contraseña con `password_hash()`.
	- Validación en servidor: campos obligatorios, `usuario` ≥ 3 caracteres, `clave` ≥ 6 caracteres.
	- Restricción de caracteres en `usuario`: solo letras, números, `_` y `-`.
	- Manejo de unicidad: devuelve mensaje claro si el usuario ya existe.
	- Interfaz en español.
- **Inicio de sesión y sesiones** (`login.php`, `protected.php`, `logout.php`):
	- Verificación con `password_verify()`.
	- Inicio de sesión seguro: `session_start()` y `session_regenerate_id(true)` al loguear.
	- `protected.php` exige sesión activa; `logout.php` destruye sesión y cookies.
	- Interfaz en español.
- **Mensajes y seguridad**: no se muestran excepciones internas al usuario; se usan respuestas amigables.

## Archivos principales
- `crear_tabla.php` — crea la BD y la tabla.
- `conexion.php` — conexión PDO y creación automática de la tabla si falta.
- `registro.php` — formulario y lógica de registro con validación y hashing.
- `login.php` — formulario y lógica de login con manejo de sesión y redirección.
- `protected.php` — ejemplo de página protegida que exige sesión.
- `logout.php` — cierre de sesión seguro.
- `database/usuarios.db` — archivo SQLite (se genera al ejecutar `crear_tabla.php`).

## Funcionalidades adicionales implementadas
- Validación servidor-side (longitud mínima, caracteres permitidos para usuario).
- Detección y manejo de usuario duplicado (UNIQUE constraint).
- Creación automática de tabla desde `conexion.php` para evitar errores al desplegar.
- Gestión de sesiones completa: login con regeneración de id de sesión, página protegida y cierre de sesión que limpia cookies.

## Resumen final
- Los requisitos solicitados por el docente están implementados: creación de BD, registro seguro, login con verificación de hash y uso de PDO.
- Además se añadieron validaciones, manejo de unicidad, y gestión de sesiones con páginas protegidas en español.