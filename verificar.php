<?php
// Verificador de configuración del laboratorio OWASP
echo "<html><head><title>Verificador de Configuración</title></head><body>";
echo "<h1>🔧 Verificador de Configuración del Laboratorio</h1>";

// Verificar conexión a base de datos
include 'config.php';

echo "<h2>📊 Estado de la Base de Datos:</h2>";

if ($conn) {
    echo "✅ <span style='color:green;'>Conexión a MySQL exitosa</span><br>";
    
    // Verificar si existe la base de datos
    $result = mysqli_query($conn, "SHOW DATABASES LIKE 'notas'");
    if (mysqli_num_rows($result) > 0) {
        echo "✅ <span style='color:green;'>Base de datos 'notas' existe</span><br>";
        
        // Verificar tablas
        mysqli_select_db($conn, 'notas');
        
        $result = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
        if (mysqli_num_rows($result) > 0) {
            echo "✅ <span style='color:green;'>Tabla 'users' existe</span><br>";
            
            // Verificar usuarios
            $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
            $row = mysqli_fetch_assoc($result);
            echo "👥 <span style='color:blue;'>Usuarios en la base: " . $row['count'] . "</span><br>";
            
            // Mostrar usuarios para verificación
            echo "<h3>👤 Usuarios disponibles:</h3>";
            $result = mysqli_query($conn, "SELECT username, password FROM users");
            echo "<table border='1' style='border-collapse:collapse; padding:5px;'>";
            echo "<tr><th>Usuario</th><th>Contraseña</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><strong>" . htmlspecialchars($row['username']) . "</strong></td>";
                echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
        } else {
            echo "❌ <span style='color:red;'>Tabla 'users' no existe</span><br>";
            echo "💡 <strong>Solución:</strong> Ejecuta el archivo db.sql<br>";
        }
        
        $result = mysqli_query($conn, "SHOW TABLES LIKE 'notes'");
        if (mysqli_num_rows($result) > 0) {
            echo "✅ <span style='color:green;'>Tabla 'notes' existe</span><br>";
            
            $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM notes");
            $row = mysqli_fetch_assoc($result);
            echo "📝 <span style='color:blue;'>Notas en la base: " . $row['count'] . "</span><br>";
        } else {
            echo "❌ <span style='color:red;'>Tabla 'notes' no existe</span><br>";
        }
        
    } else {
        echo "❌ <span style='color:red;'>Base de datos 'notas' no existe</span><br>";
        echo "💡 <strong>Solución:</strong> Ejecuta el archivo db.sql<br>";
    }
    
} else {
    echo "❌ <span style='color:red;'>Error de conexión a MySQL</span><br>";
    echo "Error: " . mysqli_connect_error() . "<br>";
    echo "💡 <strong>Verifica que MySQL esté corriendo y las credenciales en config.php</strong><br>";
}

echo "<h2>🧪 Instrucciones de Uso:</h2>";
echo "<ol>";
echo "<li><strong>Login Normal:</strong><br>";
echo "   • Usuario: <code>admin</code><br>";
echo "   • Contraseña: <code>admin123</code></li>";
echo "<li><strong>SQL Injection - Opción 1:</strong><br>";
echo "   • Usuario: <code>admin</code><br>";
echo "   • Contraseña: <code>' OR '1'='1</code></li>";
echo "<li><strong>SQL Injection - Opción 2:</strong><br>";
echo "   • Usuario: <code>admin</code><br>";
echo "   • Contraseña: <code>' OR 1=1--</code></li>";
echo "<li><strong>SQL Injection - Opción 3:</strong><br>";
echo "   • Usuario: <code>' OR '1'='1'--</code><br>";
echo "   • Contraseña: <code>cualquiera</code></li>";
echo "</ol>";

echo "<h3>🔍 Ejemplos de Queries SQL que se generan:</h3>";
echo "<div style='background:#f8f9fa; padding:10px; margin:10px; border-radius:5px; font-family:monospace;'>";
echo "<strong>Login normal:</strong><br>";
echo "SELECT * FROM users WHERE username='admin' AND password='admin123'<br><br>";
echo "<strong>SQL Injection exitoso:</strong><br>";
echo "SELECT * FROM users WHERE username='admin' AND password='' OR '1'='1'<br>";
echo "→ Esto devuelve TODOS los usuarios porque '1'='1' siempre es verdadero<br><br>";
echo "<strong>Con comentario SQL:</strong><br>";
echo "SELECT * FROM users WHERE username='' OR '1'='1'--' AND password='cualquiera'<br>";
echo "→ El -- comenta el resto de la query<br>";
echo "</div>";

echo "<h2>🔗 Enlaces del Laboratorio:</h2>";
echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<a href='index.php' style='background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin: 5px;'>🏠 Inicio</a> ";
echo "<a href='login.php' style='background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔑 Login</a> ";
echo "<a href='register.php' style='background: #ffc107; color: black; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin: 5px;'>📝 Registro</a>";
echo "</div>";

echo "<hr>";
echo "<p><em>Si ves usuarios disponibles arriba, la configuración está correcta.</em></p>";
echo "</body></html>";
?>
