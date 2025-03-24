<?php
session_start();

// Validar si el usuario esta activo
function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: /auth/login.php");
        exit();
    }
    
    // Verificar si el usuario sigue activo en cada solicitud
    global $pdo;
    $stmt = $pdo->prepare("SELECT Estado FROM Usuario WHERE ID_Usuario = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $usuario = $stmt->fetch();
    
    if ($usuario['Estado'] !== 'Activo') {
        session_unset();
        session_destroy();
        header("Location: /auth/login.php?error=Cuenta desactivada");
        exit();
    }
}
// Verificar autenticación
function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: /auth/login.php");
        exit();
    }
}

// Verificar rol específico
function checkRole($requiredRole) {
    if ($_SESSION['rol'] !== $requiredRole) {
        http_response_code(403);
        die("Acceso denegado: No tienes los permisos necesarios.");
    }
}

// Middleware para rutas protegidas
function requireAuth() {
    checkAuth();
}

// Middleware para roles específicos
function requireRole($roles) {
    checkAuth();
    if (!in_array($_SESSION['rol'], (array)$roles)) {
        http_response_code(403);
        die("Acceso denegado: Rol no autorizado.");
    }
}
?>