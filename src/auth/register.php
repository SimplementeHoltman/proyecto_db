<?php
session_start();
require_once '../includes/middleware.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Verificar rol Superadmin
if ($_SESSION['rol'] !== 'Superadmin') {
    die("Acceso denegado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $id_rol = $_POST['id_rol'];

    // Hash de contraseña
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO Usuario (Nombre, Apellido, Correo, Contraseña, ID_Rol) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $apellido, $correo, $hash, $id_rol]);
    header("Location: ../dashboard/crear_editar_usuario.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Crear Usuario</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <select name="id_rol" required>
            <option value="">Seleccionar Rol</option>
            <?php
            $roles = $pdo->query("SELECT * FROM Rol")->fetchAll();
            foreach ($roles as $rol) {
                echo "<option value='{$rol['ID_Rol']}'>{$rol['Nombre_Rol']}</option>";
            }
            ?>
        </select>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>