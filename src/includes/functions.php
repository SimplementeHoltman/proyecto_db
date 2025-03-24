<?php
require_once __DIR__ . '/db.php';

// Generar hash de contraseña
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verificar contraseña
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Sanitizar entradas
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Obtener usuario actual
function getCurrentUser() {
    if (!isset($_SESSION['user_id'])) return null;
    
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT u.*, r.Nombre_Rol as rol 
            FROM Usuario u
            JOIN Rol r ON u.ID_Rol = r.ID_Rol
            WHERE ID_Usuario = ?
        ");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        return null;
    }
}
?>