<?php
// src/dashboard/eliminar_usuario.php
require_once __DIR__ . '/../includes/middleware.php';
require_once __DIR__ . '/../includes/db.php';

// Solo Superadmin puede desactivar
requireRole(['Superadmin']);

if (isset($_GET['id'])) {
    try {
        // Actualizar estado a Inactivo
        $stmt = $pdo->prepare("
            UPDATE Usuario 
            SET Estado = 'Inactivo' 
            WHERE ID_Usuario = ?
        ");
        $stmt->execute([$_GET['id']]);
        
        $_SESSION['success'] = "Usuario desactivado correctamente";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al desactivar: " . $e->getMessage();
    }
}

// Redirigir de vuelta a la lista de usuarios
header("Location: usuarios.php");
exit;
?>