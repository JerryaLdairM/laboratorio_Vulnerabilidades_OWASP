<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Nota - Notas Seguras</title>
    <style>
        body {
            background: #f4f6fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 24px;
        }
        h2 {
            color: #3a3a3a;
            margin-bottom: 24px;
        }
        .note-content {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 16px;
            margin: 16px 0;
            min-height: 100px;
        }
        .actions {
            margin-top: 20px;
        }
        a {
            color: #4f8cff;
            text-decoration: none;
            margin-right: 15px;
        }
        a:hover {
            text-decoration: underline;
        }
        .delete-link {
            color: #dc3545;
        }
        .user-info {
            font-size: 0.9em;
            color: #6c757d;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
<?php
include 'config.php';
session_start();

// A01: Broken Access Control - Sin verificación de propiedad de la nota
$id = $_GET['id'];
$sql = "SELECT * FROM notes WHERE id=$id"; // A03: SQL Injection vulnerable
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo "<h2>📝 Nota #$id</h2>";
    echo "<div class='user-info'>👤 Propietario: " . htmlspecialchars($row['user']) . "</div>";
    echo "<div class='note-content'>";
    echo $row['note']; // A03: XSS - Sin sanitización
    echo "</div>";
    
    echo "<div class='actions'>";
    echo "<a href='notes.php'>← Volver a mis notas</a> | ";
    echo "<a href='index.php'>🏠 Inicio</a> | ";
    echo "<a href='note_delete.php?id=$id' class='delete-link' onclick='return confirm(\"¿Eliminar esta nota?\")'>🗑️ Eliminar</a>";
    echo "</div>";
} else {
    echo "<h2>❌ Nota no encontrada</h2>";
    echo "<p>La nota con ID $id no existe.</p>";
    echo "<a href='notes.php'>← Volver a mis notas</a> | ";
    echo "<a href='index.php'>🏠 Volver al inicio</a>";
}
?>
</div>
</body>
</html> 