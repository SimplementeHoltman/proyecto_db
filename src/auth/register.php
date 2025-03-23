<?php
require '../includes/db.php';
require '../includes/middleware.php';
require_role([1]); // Solo Superadmin (ID_Rol = 1)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $id_rol = $_POST['id_rol'];

    $stmt = $pdo->prepare("INSERT INTO Usuario (Nombre, Apellido, Correo, Contraseña, ID_Rol) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $apellido, $correo, $contraseña, $id_rol]);
    header("Location: ../dashboard/crear_editar_usuario.php");
    exit();
}
?>

<!-- Formulario HTML omitido por brevedad -->