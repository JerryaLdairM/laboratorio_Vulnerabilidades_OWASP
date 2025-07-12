<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Notas Seguras</title>
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
    <h2>Iniciar sesión</h2>
    <?php
    include 'config.php';
    session_start();
    
    // A07: Sin límite de intentos de login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        
        // A03: SQL Injection vulnerable - Sin prepared statements
        $sql = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
        
        // Mostrar la query para propósitos educativos
        echo "<div style='background:#e3f2fd; border:1px solid #1976d2; padding:10px; margin:10px 0; border-radius:4px;'>";
        echo "<strong>🔍 Query SQL ejecutada:</strong><br>";
        echo "<code>$sql</code>";
        echo "</div>";
        
        $result = mysqli_query($conn, $sql);
        
        // A05: Security Misconfiguration - Muestra query en caso de error
        if (!$result) {
            echo "<div style='color:red; background:#ffe6e6; padding:10px; margin:10px 0; border-radius:4px;'>";
            echo "❌ Error de base de datos:<br>";
            echo "<strong>Query:</strong> $sql<br>";
            echo "<strong>Error:</strong> " . mysqli_error($conn);
            echo "</div>";
        } else if (mysqli_num_rows($result) >= 1) {
            // Cambio: >= 1 en lugar de == 1 para permitir SQL injection que devuelva múltiples filas
            $_SESSION['user'] = $user; // A07: Sesión sin regeneración de ID
            echo "<div style='color:green; background:#d4edda; padding:10px; margin:10px 0; border-radius:4px;'>";
            echo "✅ Login exitoso! Filas encontradas: " . mysqli_num_rows($result);
            echo "<br>Redirigiendo...";
            echo "</div>";
            header("refresh:2;url=notes.php");
            exit;
        } else {
            echo "<div style='color:red; background:#ffe6e6; padding:10px; margin:10px 0; border-radius:4px;'>";
            echo "❌ Login incorrecto - No se encontraron usuarios<br>";
            echo "<strong>Usuario ingresado:</strong> " . htmlspecialchars($user) . "<br>";
            echo "<strong>Contraseña ingresada:</strong> " . htmlspecialchars($pass) . "<br>";
            echo "<strong>Filas encontradas:</strong> " . mysqli_num_rows($result) . "<br>";
            echo "<hr style='margin:10px 0;'>";
            echo "💡 <strong>Credenciales válidas:</strong><br>";
            echo "• Usuario: <code>admin</code> / Contraseña: <code>admin123</code><br>";
            echo "• Usuario: <code>user1</code> / Contraseña: <code>123456</code><br>";
            echo "• Usuario: <code>test</code> / Contraseña: <code>password</code><br>";
            echo "<hr style='margin:10px 0;'>";
            echo "🔓 <strong>SQL Injection:</strong><br>";
            echo "• Usuario: <code>admin</code> / Contraseña: <code>' OR '1'='1</code><br>";
            echo "• Usuario: <code>admin</code> / Contraseña: <code>' OR 1=1--</code><br>";
            echo "• Usuario: <code>' OR '1'='1'--</code> / Contraseña: <code>cualquiera</code><br>";
            echo "<hr style='margin:10px 0;'>";
            echo "🔧 <strong>¿Problemas?</strong> <a href='verificar.php'>Verificar configuración</a>";
            echo "</div>";
        }
    }
    ?>
    <form method="post">
        Usuario: <input name="user" required><br>
        Contraseña: <input name="pass" type="password" required><br>
        <button type="submit">Entrar</button>
    </form>
    <div style="margin-top:16px;">
        <a href="register.php">¿No tienes cuenta? Regístrate</a><br>
        <a href="index.php" style="margin-top: 10px; display: inline-block;">🏠 Volver al inicio</a>
    </div>
</div>
</body>
</html> 