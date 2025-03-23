<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php");
    exit();
}

// Verificar estado del usuario (ej: inactivo)
$pdo = require 'db.php';
$stmt = $pdo->prepare("SELECT Estado FROM Usuario WHERE ID_Usuario = ?");
$stmt->execute([$_SESSION['user_id']]);
$estado = $stmt->fetchColumn();

if ($estado !== 'Activo') {
    session_destroy();
    die("Su cuenta está inactiva.");
}
?>