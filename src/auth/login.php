<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Redirigir usuarios ya autenticados
if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    try {
        // Validación básica de campos
        if (empty($correo) || empty($password)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        // Consulta mejorada con solo los campos necesarios
        $stmt = $pdo->prepare("
            SELECT 
                u.ID_Usuario,
                u.Nombre,
                u.Contraseña,
                u.Estado,
                r.Nombre_Rol as rol 
            FROM Usuario u
            INNER JOIN Rol r ON u.ID_Rol = r.ID_Rol
            WHERE u.Correo = ?
        ");
        
        if (!$stmt->execute([$correo])) {
            throw new Exception("Error en la consulta");
        }

        $usuario = $stmt->fetch();

        if (!$usuario) {
            throw new Exception("Credenciales inválidas");
        }

        // Verificar estado del usuario
        if ($usuario['Estado'] !== 'Activo') {
            throw new Exception("Cuenta desactivada. Contacte al administrador.");
        }

        // Verificar contraseña
        if (!password_verify($password, $usuario['Contraseña'])) {
            throw new Exception("Credenciales inválidas");
        }

        // Regenerar ID de sesión para prevenir fixation
        session_regenerate_id(true);

        // Establecer datos de sesión
        $_SESSION['user_id'] = $usuario['ID_Usuario'];
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['nombre'] = $usuario['Nombre'];
        $_SESSION['last_activity'] = time();

        // Limpiar URL de redirección
        $redirect = $_SESSION['redirect_url'] ?? '../index.php';
        unset($_SESSION['redirect_url']);
        
        header("Location: " . $redirect);
        exit();

    } catch (Exception $e) {
        // Registrar error (opcional)
        error_log("Error de login: " . $e->getMessage());
        
        $_SESSION['error'] = $e->getMessage();
        header("Location: /auth/login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php include_once '../includes/navbar.php'; ?>
    
    <main>
        <h1>Iniciar Sesión</h1>
        
        <?php if(isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div>
                <label>Correo:</label>
                <input type="email" name="email" required>
            </div>
            
            <div>
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit">Ingresar</button>
        </form>
    </main>
</body>
</html>