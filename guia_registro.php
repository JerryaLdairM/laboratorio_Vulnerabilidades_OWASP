<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guía de Vulnerabilidades - Registro</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .vulnerability { background: #f8f9fa; border-left: 4px solid #007bff; padding: 15px; margin: 15px 0; }
        .exploit { background: #fff3cd; border-left: 4px solid #ffc107; padding: 10px; margin: 10px 0; }
        .dangerous { background: #f8d7da; border-left: 4px solid #dc3545; padding: 10px; margin: 10px 0; }
        code { background: #e9ecef; padding: 2px 5px; border-radius: 3px; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>

<h1>🎯 Vulnerabilidades en el Registro - Guía de Explotación</h1>

<div class="vulnerability">
    <h2>🔐 A02: Cryptographic Failures</h2>
    <p><strong>Descripción:</strong> Las contraseñas se almacenan en texto plano sin ningún tipo de cifrado.</p>
    
    <div class="exploit">
        <h3>✅ Cómo probarlo:</h3>
        <ol>
            <li>Registra un usuario con cualquier contraseña</li>
            <li>Ve al panel de administración (<code>admin.php</code>)</li>
            <li>Observa que tu contraseña aparece en texto plano</li>
        </ol>
        
        <p><strong>Ejemplo:</strong></p>
        <ul>
            <li>Usuario: <code>test123</code></li>
            <li>Contraseña: <code>mipassword</code></li>
        </ul>
        <p>La contraseña se guarda exactamente como "mipassword" en la base de datos.</p>
    </div>
</div>

<div class="vulnerability">
    <h2>💉 A03: SQL Injection</h2>
    <p><strong>Descripción:</strong> Los campos de usuario y contraseña son vulnerables a inyección SQL.</p>
    
    <div class="exploit">
        <h3>✅ Pruebas básicas:</h3>
        
        <h4>1. Inyección en el campo Usuario:</h4>
        <ul>
            <li>Usuario: <code>test'); -- comentario</code></li>
            <li>Contraseña: <code>cualquiera</code></li>
        </ul>
        
        <h4>2. Romper la query con comillas:</h4>
        <ul>
            <li>Usuario: <code>test'</code></li>
            <li>Contraseña: <code>pass</code></li>
        </ul>
        <p>Esto debería mostrar un error de MySQL revelando la estructura de la query.</p>
    </div>
    
    <div class="dangerous">
        <h3>⚠️ Pruebas avanzadas (¡Cuidado!):</h3>
        
        <h4>3. Insertar múltiples usuarios:</h4>
        <ul>
            <li>Usuario: <code>normal'), ('hacker', 'hacked</code></li>
            <li>Contraseña: <code>pass</code></li>
        </ul>
        <p>Esto insertará dos usuarios: "normal" y "hacker"</p>
        
        <h4>4. Intentar mostrar información de la base:</h4>
        <ul>
            <li>Usuario: <code>test'); SELECT * FROM users; --</code></li>
            <li>Contraseña: <code>cualquiera</code></li>
        </ul>
        
        <p><strong>Query resultante:</strong></p>
        <pre>INSERT INTO users (username, password) VALUES ('test'); SELECT * FROM users; --', 'cualquiera')</pre>
    </div>
</div>

<div class="vulnerability">
    <h2>⚙️ A05: Security Misconfiguration</h2>
    <p><strong>Descripción:</strong> La aplicación muestra errores detallados y información sensible.</p>
    
    <div class="exploit">
        <h3>✅ Cómo verlo:</h3>
        <ol>
            <li>Intenta registrar un usuario que ya existe</li>
            <li>Usa caracteres especiales que rompan la query SQL</li>
            <li>Observa los errores detallados de MySQL que se muestran</li>
        </ol>
        
        <p><strong>Ejemplo:</strong></p>
        <ul>
            <li>Usuario: <code>admin</code> (que ya existe)</li>
            <li>Contraseña: <code>cualquiera</code></li>
        </ul>
        <p>Verás el error completo de "Duplicate entry" con detalles de la base de datos.</p>
    </div>
</div>

<div class="vulnerability">
    <h2>🔑 A07: Authentication Failures</h2>
    <p><strong>Descripción:</strong> Sin validación de contraseñas débiles y políticas de seguridad.</p>
    
    <div class="exploit">
        <h3>✅ Pruebas de contraseñas débiles:</h3>
        
        <h4>1. Contraseñas extremadamente cortas:</h4>
        <ul>
            <li>Usuario: <code>user1</code></li>
            <li>Contraseña: <code>1</code> (solo un carácter)</li>
        </ul>
        
        <h4>2. Contraseñas comunes:</h4>
        <ul>
            <li>Contraseña: <code>123</code></li>
            <li>Contraseña: <code>password</code></li>
            <li>Contraseña: <code>admin</code></li>
            <li>Contraseña: <code>qwerty</code></li>
        </ul>
        
        <h4>3. Contraseñas vacías o espacios:</h4>
        <ul>
            <li>Usuario: <code>test</code></li>
            <li>Contraseña: <code>   </code> (solo espacios)</li>
        </ul>
    </div>
</div>

<h2>🧪 Ejercicios Prácticos</h2>

<div class="exploit">
    <h3>Nivel Principiante:</h3>
    <ol>
        <li>Registra un usuario con contraseña de 1 carácter</li>
        <li>Intenta registrar el usuario "admin" (que ya existe) para ver errores</li>
        <li>Registra y luego ve al panel admin para ver tu contraseña en texto plano</li>
    </ol>
</div>

<div class="exploit">
    <h3>Nivel Intermedio:</h3>
    <ol>
        <li>Usa comillas simples en el nombre de usuario para romper la SQL</li>
        <li>Intenta insertar múltiples usuarios con una sola operación</li>
        <li>Registra usuarios con nombres que contengan código HTML/JavaScript</li>
    </ol>
</div>

<div class="dangerous">
    <h3>Nivel Avanzado:</h3>
    <ol>
        <li>Intenta hacer SQL injection para extraer información de otras tablas</li>
        <li>Experimenta con diferentes payloads de SQL injection</li>
        <li>Combina múltiples vulnerabilidades en una sola petición</li>
    </ol>
</div>

<h2>🛡️ ¿Cómo se debería corregir?</h2>

<div class="vulnerability">
    <h3>Soluciones correctas:</h3>
    <ul>
        <li><strong>A02:</strong> Usar <code>password_hash()</code> y <code>password_verify()</code></li>
        <li><strong>A03:</strong> Usar prepared statements con parámetros</li>
        <li><strong>A05:</strong> No mostrar errores detallados en producción</li>
        <li><strong>A07:</strong> Implementar políticas de contraseñas fuertes</li>
    </ul>
</div>

<p><a href="register.php">← Volver al registro</a> | <a href="login.php">Ir al login</a> | <a href="index.php">🏠 Volver al inicio</a></p>

</body>
</html>
