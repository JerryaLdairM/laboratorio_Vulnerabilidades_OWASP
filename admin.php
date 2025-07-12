<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Notas Seguras</title>
    <style>
        body {
            background: #f4f6fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 24px;
        }
        h2 {
            color: #dc3545;
            margin-bottom: 24px;
        }
        .warning {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            padding: 12px;
            margin: 20px 0;
            color: #721c24;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background: #f8f9fa;
        }
        .sql-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🔓 Panel de Administración (INSEGURO)</h2>
    
    <div class="warning">
        ⚠️ <strong>A01: Broken Access Control</strong><br>
        Este panel no verifica si el usuario es realmente administrador.
    </div>

    <?php
    include 'config.php';
    session_start();
    
    // A01: Broken Access Control - Sin verificación de rol de admin
    // Cualquier usuario autenticado puede acceder
    
    if (!isset($_SESSION['user'])) {
        echo "<p>❌ Debes iniciar sesión para acceder.</p>";
        echo "<a href='login.php'>Ir a login</a>";
        exit;
    }
    
    echo "<p>👤 Usuario actual: " . htmlspecialchars($_SESSION['user']) . "</p>";
    echo "<p>🔑 <strong>¡Acceso concedido sin verificar permisos!</strong></p>";
    
    // A03: SQL Injection en búsqueda
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $sql = "SELECT * FROM users WHERE username LIKE '%$search%'";
        echo "<div class='sql-box'>Query ejecutada: $sql</div>";
        
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<h3>👥 Usuarios encontrados:</h3>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Usuario</th><th>Contraseña</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td><strong>" . htmlspecialchars($row['password']) . "</strong></td>"; // A02: Muestra contraseñas
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
    
    // Mostrar todas las notas de todos los usuarios
    echo "<h3>📝 Todas las notas del sistema (A01: Sin control de acceso):</h3>";
    $result = mysqli_query($conn, "SELECT * FROM notes ORDER BY id");
    echo "<table>";
    echo "<tr><th>ID</th><th>Usuario</th><th>Nota</th><th>Acciones</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['user']) . "</td>";
        echo "<td>" . $row['note'] . "</td>"; // A03: XSS sin sanitizar
        echo "<td><a href='note_delete.php?id=" . $row['id'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    
    <h3>🔍 Búsqueda de usuarios (Vulnerable a SQL Injection):</h3>
    <form method="GET">
        <input type="text" name="search" placeholder="Buscar usuario..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <div class="warning">
        💡 <strong>Pruebas de explotación:</strong><br>
        • Buscar: <code>' OR '1'='1</code> (SQL Injection)<br>
        • Buscar: <code>' UNION SELECT 1,username,password FROM users--</code><br>
        • Cualquier usuario puede acceder a este panel
    </div>
    
    <div style="margin-top: 20px; text-align: center;">
        <a href="notes.php">← Volver a notas</a> | 
        <a href="index.php">🏠 Volver al inicio</a>
    </div>
</div>
</body>
</html>
