# Sistema de Autenticación con SQLite y Hash Seguro

## 📋 Descripción del Proyecto

Este proyecto implementa un sistema de autenticación completo y seguro utilizando PHP, SQLite y las funciones nativas de hash de contraseñas de PHP (`password_hash()` y `password_verify()`). El sistema incluye registro de usuarios, inicio de sesión, gestión de sesiones y páginas protegidas.

---

## ✅ Requisitos Cumplidos

### Requisitos Obligatorios Completados:

1. **✓ Validación del lado del servidor**
   - Longitud mínima de contraseña: 6 caracteres
   - Longitud mínima de nombre de usuario: 3 caracteres
   - Caracteres permitidos para el nombre de usuario: letras (A-Z, a-z), números (0-9), guiones (-) y guiones bajos (_)
   - Validación de campos vacíos

2. **✓ Mensajes claros y comprensibles al usuario**
   - Todos los mensajes están en español
   - Mensajes de error específicos y descriptivos
   - Uso de `htmlspecialchars()` para evitar XSS

---

## 🚀 Características Adicionales Implementadas

Además de los requisitos básicos, se implementaron las siguientes funcionalidades:

### 1. **Gestión Completa de Sesiones**
- Inicio de sesión con `session_start()`
- Regeneración del ID de sesión al iniciar sesión (`session_regenerate_id(true)`)
- Protección de páginas mediante verificación de sesión activa
- Cierre de sesión completo con destrucción de cookies y sesión

### 2. **Validación de Unicidad de Usuarios**
- Manejo de duplicados mediante captura de excepciones PDO
- Mensaje de error específico cuando un usuario ya existe
- Uso de restricción UNIQUE en la base de datos

### 3. **Arquitectura de Seguridad Robusta**
- Hash seguro de contraseñas usando `PASSWORD_DEFAULT` (bcrypt)
- Salt aleatorio generado automáticamente
- Consultas preparadas (prepared statements) para prevenir inyección SQL
- Sanitización de salida con `htmlspecialchars()`

### 4. **Páginas Protegidas**
- Página `protected.php` accesible solo con sesión activa
- Redirección automática a login si no hay sesión
- Personalización con nombre de usuario mostrado

### 5. **Sistema de Logout Seguro**
- Destrucción completa de la sesión
- Eliminación de cookies de sesión
- Redirección automática a página de login

### 6. **Interfaz en Español**
- Todos los formularios y mensajes traducidos al español
- Etiquetas descriptivas en los formularios
- Enlace directo desde login a registro

---

## 📁 Estructura del Proyecto

```
/proyecto-login/
│
├─ database/
│  └─ usuarios.db              # Base de datos SQLite
│
├─ pantallazos/                # Capturas de pantalla
│  ├─ campo_necesario.png
│  ├─ contraseña_correcta.png
│  ├─ contraseña_incorrecta.png
│  ├─ demasiado_corto.png
│  ├─ usuario_registrado.png
│  ├─ usuario_ya_existe.png
│  └─ pagina_protegida_con_logout.png
│
├─ conexion.php                # Conexión a la base de datos
├─ crear_tabla.php             # Script para crear la tabla usuarios
├─ registro.php                # Formulario de registro con validaciones
├─ login.php                   # Formulario de inicio de sesión
├─ protected.php               # Página protegida (requiere autenticación)
├─ logout.php                  # Cierre de sesión
└─ README.md                   # Este archivo
```

---

## 🔧 Instalación y Configuración

### Requisitos Previos

- PHP 8.0 o superior
- Extensión PDO SQLite habilitada
- Servidor web (Apache, Nginx) o PHP built-in server

### Pasos de Instalación

1. **Clonar o descargar el proyecto**
   ```bash
   git clone <url-del-repositorio>
   cd sistema-de-autenticacion
   ```

2. **Crear la estructura de base de datos**
   
   Ejecutar el archivo `crear_tabla.php` una sola vez para inicializar la base de datos:
   ```bash
   php crear_tabla.php
   ```
   
   O acceder vía navegador:
   ```
   http://localhost:8000/crear_tabla.php
   ```

3. **Iniciar el servidor PHP** (opcional, si no usas Apache/Nginx)
   ```bash
   php -S localhost:8000
   ```

4. **Acceder a la aplicación**
   - Registro: `http://localhost:8000/registro.php`
   - Login: `http://localhost:8000/login.php`

---

## 📖 Uso del Sistema

### Registro de Usuario

1. Acceder a `registro.php`
2. Ingresar un nombre de usuario (mínimo 3 caracteres, solo letras, números, _ y -)
3. Ingresar una contraseña (mínimo 6 caracteres)
4. Hacer clic en "Registrar"

**Validaciones activas:**
- Campos vacíos → "Error: rellene todos los campos."
- Usuario corto → "Error: el nombre de usuario debe tener al menos 3 caracteres."
- Contraseña corta → "Error: la contraseña debe tener al menos 6 caracteres."
- Caracteres no permitidos → "Error: el nombre de usuario solo puede contener letras, números, '_' y '-'."
- Usuario duplicado → "Error: el usuario ya existe."

### Inicio de Sesión

1. Acceder a `login.php`
2. Ingresar usuario y contraseña
3. Si las credenciales son correctas, se redirige a `protected.php`
4. Si son incorrectas, se muestra "Usuario o contraseña incorrectos."

### Página Protegida

- Solo accesible con sesión activa
- Muestra mensaje de bienvenida personalizado
- Incluye enlace para cerrar sesión

### Cerrar Sesión

- Hacer clic en "Cerrar sesión" desde `protected.php`
- La sesión se destruye completamente
- Redirección automática a `login.php`

---

## 🔒 Características de Seguridad Implementadas

| Característica | Implementación | Archivo |
|----------------|----------------|---------|
| **Hash de contraseñas** | `password_hash($clave, PASSWORD_DEFAULT)` | `registro.php` |
| **Verificación de contraseñas** | `password_verify($clave, $row['password'])` | `login.php` |
| **Prevención de SQL Injection** | Prepared statements con PDO | `registro.php`, `login.php` |
| **Prevención de XSS** | `htmlspecialchars()` en salidas | `registro.php`, `protected.php` |
| **Validación de entrada** | Expresiones regulares y funciones de validación | `registro.php` |
| **Regeneración de ID de sesión** | `session_regenerate_id(true)` | `login.php` |
| **Destrucción segura de sesión** | `session_destroy()` + eliminación de cookies | `logout.php` |
| **Protección de páginas** | Verificación de `$_SESSION['usuario']` | `protected.php` |

---

## 📊 Detalles Técnicos

### Base de Datos

**Tabla: usuarios**
```sql
CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario TEXT UNIQUE,
    password TEXT NOT NULL
)
```

### Función de Conexión (`conexion.php`)

```php
function conectar() {
    try {
        $db = new PDO("sqlite:database/usuarios.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
```

### Flujo de Registro

1. Usuario envía formulario POST
2. Se validan todos los campos (longitud, caracteres permitidos)
3. Se genera hash de la contraseña con `password_hash()`
4. Se inserta en la base de datos usando prepared statement
5. Se captura excepción si el usuario ya existe

### Flujo de Login

1. Usuario envía formulario POST
2. Se busca el usuario en la base de datos
3. Se verifica la contraseña con `password_verify()`
4. Si es correcta, se regenera el ID de sesión y se guarda el usuario en `$_SESSION`
5. Se redirige a la página protegida

---

## 📸 Capturas de Pantalla

El directorio `pantallazos/` contiene las siguientes capturas:

- **campo_necesario.png**: Validación de campos vacíos
- **contraseña_correcta.png**: Login exitoso
- **contraseña_incorrecta.png**: Credenciales inválidas
- **demasiado_corto.png**: Validación de longitud mínima
- **usuario_registrado.png**: Registro exitoso
- **usuario_ya_existe.png**: Manejo de duplicados
- **pagina_protegida_con_logout.png**: Área autenticada

---

## 🎯 Decisiones de Diseño

1. **SQLite como base de datos**: Elegida por su simplicidad y portabilidad, no requiere servidor de base de datos separado.

2. **PASSWORD_DEFAULT**: Utiliza bcrypt automáticamente, pero permite actualizaciones futuras del algoritmo sin cambiar el código.

3. **Validación del lado del servidor**: Todas las validaciones se realizan en el servidor para garantizar la seguridad, incluso si JavaScript está deshabilitado.

4. **Mensajes en español**: Interfaz completamente localizada para usuarios hispanohablantes.

5. **Prepared Statements**: Todas las consultas SQL usan prepared statements para prevenir inyección SQL.

6. **Arquitectura modular**: La función de conexión está separada en `conexion.php` para reutilización.

---

## 🧪 Pruebas Realizadas

✅ Registro con usuario válido  
✅ Registro con usuario duplicado  
✅ Registro con contraseña corta  
✅ Registro con usuario corto  
✅ Registro con caracteres no permitidos  
✅ Login con credenciales correctas  
✅ Login con credenciales incorrectas  
✅ Acceso a página protegida sin sesión  
✅ Acceso a página protegida con sesión  
✅ Cierre de sesión y destrucción de datos  
✅ Regeneración de ID de sesión al login  

---

## 🔄 Mejoras Futuras Posibles

- Implementar recuperación de contraseña por correo electrónico
- Añadir verificación de cuenta por email
- Implementar rate limiting para prevenir fuerza bruta
- Añadir autenticación de dos factores (2FA)
- Crear panel de administración
- Implementar niveles de usuario (roles)
- Añadir logs de auditoría de accesos
- Mejorar el diseño con CSS/framework

---

## 📝 Licencia

Este proyecto es de código abierto y está disponible para fines educativos.

---

## 👨‍💻 Autor

Desarrollado como proyecto educativo para demostrar la implementación segura de un sistema de autenticación con PHP y SQLite.

---

## 📚 Referencias

- [Documentación de password_hash()](https://www.php.net/manual/es/function.password-hash.php)
- [Documentación de password_verify()](https://www.php.net/manual/es/function.password-verify.php)
- [PDO en PHP](https://www.php.net/manual/es/book.pdo.php)
- [Guía de seguridad en PHP](https://www.php.net/manual/es/security.php)