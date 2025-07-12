# 🔓 Notas Seguras - Laboratorio de Vulnerabilidades OWASP Top 10

Este proyecto es una aplicación PHP **intencionalmente vulnerable** diseñada para demostrar las principales vulnerabilidades del OWASP Top 10:

- **A01: Broken Access Control** 🚫
- **A02: Cryptographic Failures** 🔐
- **A03: Injection (SQL, XSS)** 💉
- **A05: Security Misconfiguration** ⚙️
- **A07: Identification & Authentication Failures** 🔑

## 🚀 Instalación

1. **Configura tu servidor local** (XAMPP, WAMP, etc.)
2. **Crea la base de datos** ejecutando `db.sql`
3. **Coloca los archivos** en la carpeta del servidor web
4. **Accede** a `index.php` desde tu navegador

## 📊 Credenciales de Prueba

- **admin** / **admin123** (administrador)
- **user1** / **123456** (usuario normal)
- **test** / **password** (usuario de prueba)

## 🎯 Vulnerabilidades y Cómo Explotarlas

### 🚫 A01: Broken Access Control
**Pruebas:**
- Ve a `note_view.php?id=1` y cambia el ID para ver notas de otros
- Elimina notas ajenas con `note_delete.php?id=1`
- Accede a `admin.php` con cualquier usuario autenticado

### 🔐 A02: Cryptographic Failures
**Pruebas:**
- Las contraseñas se almacenan en texto plano
- Ve el panel admin para ver todas las contraseñas
- No se usa HTTPS (comunicación insegura)

### 💉 A03: Injection (SQL, XSS)
**SQL Injection:**
- Login: `admin` / `' OR '1'='1`
- Búsqueda admin: `' UNION SELECT 1,username,password FROM users--`

**XSS:**
- Nota: `<script>alert('XSS!')</script>`
- Nota: `<img src="x" onerror="alert('Cookie: ' + document.cookie)">`

### ⚙️ A04: Security Misconfiguration
**Pruebas:**
- Información sensible expuesta en `index.php`
- Errores detallados visibles
- Credenciales hardcodeadas en `config.php`

### 🔑 A05: Authentication Failures
**Pruebas:**
- Contraseñas débiles permitidas (registra con "123")
- Sin límite de intentos de login
- Sesiones sin regeneración de ID

---

**⚠️ ¡Usa este laboratorio solo con fines educativos!**

## Instalación

1. Crea una base de datos llamada `notas` y ejecuta el script `db.sql`.
2. Coloca los archivos en tu servidor web local (XAMPP, WAMP, etc).
3. Accede a `index.php` desde tu navegador.

## Script SQL (`db.sql`)

## Vulnerabilidades y cómo explotarlas

### A01: Broken Access Control
- Accede a `note_view.php?id=1` o cambia el ID en la URL para ver notas de otros usuarios.
- Elimina notas de otros usuarios con `note_delete.php?id=1`.

### A02: Cryptographic Failures
- Las contraseñas se almacenan en texto plano (ver tabla `users`).
- No se usa HTTPS.

### A03: Injection (SQL, XSS)
- SQL Injection: Prueba `' OR '1'='1` en login o registro.
- XSS: Escribe `<script>alert(1)</script>` en una nota y visualízala.

### A05: Security Misconfiguration
- Credenciales expuestas en `config.php`.
- Errores detallados visibles.

### A07: Identification & Authentication Failures
- Contraseñas débiles permitidas.
- No hay límite de intentos de login.
- Sesiones gestionadas sin seguridad.

---

**¡Usa este laboratorio solo con fines educativos!** 