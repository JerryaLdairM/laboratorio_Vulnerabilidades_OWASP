<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas Seguras - Laboratorio OWASP</title>
    <style>
        body {
            background: #f4f6fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 80px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 24px;
            text-align: center;
        }
        h1 {
            color: #3a3a3a;
            margin-bottom: 16px;
        }
        .warning {
            background: #fef3cd;
            border: 1px solid #fdbf47;
            border-radius: 6px;
            padding: 12px;
            margin: 20px 0;
            color: #664d03;
        }
        a {
            color: #4f8cff;
            text-decoration: none;
            font-size: 1.1em;
            margin: 0 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .debug-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 0.9em;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🔓 Notas Seguras</h1>
    <div class="warning">
        ⚠️ <strong>Laboratorio de Vulnerabilidades OWASP</strong><br>
        Esta aplicación contiene vulnerabilidades intencionalmente para fines educativos.
    </div>
    
    <p>Bienvenido al sistema de gestión de notas personales</p>
    
    <div>
        <a href="register.php">Registrarse</a> | 
        <a href="login.php">Iniciar sesión</a> |
        <a href="analisis_vulnerabilidades.html">📊 Análisis de Vulnerabilidades</a> |
        <a href="propuestas_solucion.php">🛡️ Propuestas de Solución</a>
    </div>
    
    <!-- A05: Security Misconfiguration - Información sensible expuesta -->
    <div class="debug-info">
        <strong>Debug Info (¡No debería estar visible!):</strong><br>
        PHP Version: <?php echo phpversion(); ?><br>
        Server: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?><br>
        Database: notas@localhost<br>
        Admin credentials: admin/admin123
    </div>
</div>
</body>
</html> 