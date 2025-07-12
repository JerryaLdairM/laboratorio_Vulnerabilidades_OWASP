<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse - Notas Seguras</title>
    <style>
        body {
            background: #f4f6fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 24px;
            text-align: center;
        }
        h2 {
            color: #3a3a3a;
            margin-bottom: 24px;
        }
        input, textarea {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1em;
        }
        button {
            background: #4f8cff;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 24px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s;
        }
        button:hover {
            background: #2563eb;
        }
        a {
            color: #4f8cff;
            text-decoration: none;
            font-size: 0.95em;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Registrarse</h2>
    <?php
    include 'config.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST['user'];
        $pass = $_POST['pass']; // A02: Cryptographic Failures - Sin hash
        
        // A07: Sin validación de contraseña fuerte
        if (strlen($pass) < 3) {
            echo "<div style='color:orange; background:#fff3cd; padding:10px; margin:10px 0; border-radius:4px;'>";
            echo "⚠️ Contraseña muy corta, pero la aceptamos igual 😅";
            echo "</div>";
        }
        
        // A03: SQL Injection vulnerable
        $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
        
        // Mostrar la query para propósitos educativos
        echo "<div style='background:#e3f2fd; border:1px solid #1976d2; padding:10px; margin:10px 0; border-radius:4px;'>";
        echo "<strong>🔍 Query SQL ejecutada:</strong><br>";
        echo "<code>$sql</code>";
        echo "</div>";
        
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            echo "<div style='color:green; background:#d4edda; padding:10px; margin:10px 0; border-radius:4px;'>";
            echo "✅ Usuario registrado exitosamente!<br>";
            echo "<strong>Usuario:</strong> '$user'<br>";
            echo "<strong>Contraseña:</strong> '$pass' (almacenada en texto plano - A02)<br>";
            echo "🔓 Ahora puedes hacer login con estas credenciales";
            echo "</div>";
            header("refresh:3;url=login.php");
        } else {
            // A05: Security Misconfiguration - Muestra errores detallados
            echo "<div style='color:red; background:#ffe6e6; padding:10px; margin:10px 0; border-radius:4px;'>";
            echo "❌ Error al registrar usuario:<br>";
            echo "<strong>Query ejecutada:</strong> $sql<br>";
            echo "<strong>Error de MySQL:</strong> " . mysqli_error($conn) . "<br>";
            echo "<strong>Código de error:</strong> " . mysqli_errno($conn);
            echo "</div>";
        }
    }
    ?>
    
    <!-- Información sobre vulnerabilidades para el laboratorio -->
    <div style='background:#fff3cd; border:1px solid #fdbf47; padding:10px; margin:10px 0; border-radius:4px; font-size:0.9em;'>
        <strong>🎯 Vulnerabilidades que puedes probar:</strong><br>
        • <strong>A02:</strong> Contraseñas sin cifrar<br>
        • <strong>A03:</strong> SQL Injection en campos de usuario<br>
        • <strong>A05:</strong> Errores detallados expuestos<br>
        • <strong>A07:</strong> Sin validación de contraseñas
    </div>
    <form method="post">
        Usuario: <input name="user" required><br>
        Contraseña: <input name="pass" type="password" required><br>
        <button type="submit">Registrar</button>
    </form>
    <div style="margin-top:16px;">
        <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a> | 
        <a href="guia_registro.php">📚 Guía de vulnerabilidades</a><br>
        <a href="index.php" style="margin-top: 10px; display: inline-block;">🏠 Volver al inicio</a>
    </div>
</div>
</body>
</html> 