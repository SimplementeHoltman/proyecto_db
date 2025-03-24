<?php
session_start();

require_once __DIR__ . '/db.php'; // Incluir la conexión primero

// Verificar autenticación
function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: /auth/login.php");
        exit();
    }
    
    // Acceder a la conexión PDO desde el ámbito global
    global $pdo;
    
    try {
        // Verificar estado del usuario
        $stmt = $pdo->prepare("SELECT Estado FROM Usuario WHERE ID_Usuario = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $usuario = $stmt->fetch();

        if ($usuario['Estado'] !== 'Activo') {
            session_unset();
            session_destroy();
            header("Location: /auth/login.php?error=Cuenta desactivada");
            exit();
        }
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

// Verificar roles
function requireRole($roles) {
    checkAuth();
    if (!in_array($_SESSION['rol'], (array)$roles)) {
        http_response_code(403);
        die("Acceso denegado: Rol {$_SESSION['rol']} no autorizado.");
    }
}
?>