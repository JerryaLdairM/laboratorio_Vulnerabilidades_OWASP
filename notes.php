<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Notas - Notas Seguras</title>
    <style>
        body {
            background: #f4f6fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 24px;
        }
        h2 {
            color: #3a3a3a;
            margin-bottom: 24px;
            text-align: center;
        }
        .note-list {
            margin-bottom: 24px;
        }
        .note-item {
            background: #f1f5fb;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .note-item a {
            color: #4f8cff;
            text-decoration: none;
            font-weight: 500;
        }
        .note-item a:hover {
            text-decoration: underline;
        }
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1em;
            resize: vertical;
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
        .logout {
            display: block;
            margin: 0 auto 16px auto;
            text-align: right;
            color: #4f8cff;
            text-decoration: none;
            font-size: 0.95em;
        }
        .logout:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <a class="logout" href="logout.php">Cerrar sesión</a>
    <a class="logout" href="admin.php" style="margin-right: 10px;">🔧 Panel Admin</a>
    <h2>Mis Notas</h2>
    <div class="note-list">
    <?php
    include 'config.php';
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }
    $user = $_SESSION['user'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $note = $_POST['note'];
        $sql = "INSERT INTO notes (user, note) VALUES ('$user', '$note')"; // A03: SQL Injection
        mysqli_query($conn, $sql);
    }
    $result = mysqli_query($conn, "SELECT * FROM notes WHERE user='$user'");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='note-item'><span><a href='note_view.php?id={$row['id']}'>Ver nota</a></span></div>";
    }
    ?>
    </div>
    <form method="post">
        Nueva nota:<br>
        <textarea name="note" required></textarea><br>
        <button type="submit">Guardar</button>
    </form>
    <div style="margin-top: 20px; text-align: center;">
        <a href="index.php" style="color: #4f8cff; text-decoration: none;">🏠 Volver al inicio</a>
    </div>
</div>
</body>
</html> 