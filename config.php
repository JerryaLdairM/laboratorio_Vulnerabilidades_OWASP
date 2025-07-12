<?php
// A05: Security Misconfiguration - Credenciales expuestas en código
$host = "localhost";
$user = "root";  // Usuario por defecto
$pass = "";      // Sin contraseña (típico de XAMPP)
$db = "notas";

// A05: Configuración insegura - Mostrar errores en producción
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    // A05: Muestra información sensible del servidor
    die("Error de conexión detallado: " . mysqli_connect_error() . 
        "<br>Host: $host<br>User: $user<br>Database: $db");
}

// A05: Configuración de MySQL insegura
mysqli_query($conn, "SET sql_mode = ''"); // Permite datos inválidos
?> 