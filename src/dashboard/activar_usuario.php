<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/middleware.php';

// Solo Superadmin puede reactivar
requireRole(['Superadmin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $id_usuario = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        
        if (!$id_usuario) {
            throw new Exception("ID de usuario inválido");
        }

        $stmt = $pdo->prepare("
            UPDATE Usuario 
            SET Estado = 'Activo' 
            WHERE ID_Usuario = ?
        ");
        $stmt->execute([$id_usuario]);
        
        if ($stmt->rowCount() === 0) {
            throw new Exception("Usuario no encontrado");
        }
        
        $_SESSION['success'] = "Usuario reactivado correctamente";
        
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

header("Location: usuarios.php");
exit;
?>