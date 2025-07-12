<?php
include 'config.php';
session_start();

// A01: Broken Access Control - Cualquiera puede eliminar notas de otros
$id = $_GET['id'];

// A03: SQL Injection vulnerable
$sql = "DELETE FROM notes WHERE id=$id";
$result = mysqli_query($conn, $sql);

if ($result) {
    // A05: Security Misconfiguration - Muestra información sensible
    echo "<!DOCTYPE html>
    <html><head><title>Nota Eliminada</title></head><body>
    <h2>✅ Nota eliminada exitosamente</h2>
    <p>Nota con ID $id ha sido eliminada.</p>
    <p><strong>Query ejecutada:</strong> $sql</p>
    <a href='notes.php'>Volver a notas</a>
    </body></html>";
} else {
    echo "Error: " . mysqli_error($conn); // A05: Muestra errores detallados
}

// Redirigir después de 3 segundos
header("refresh:3;url=notes.php");
?> 