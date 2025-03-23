<?php
session_start();
require 'includes/db.php';
require 'includes/middleware.php';

// Función para verificar si el usuario está logueado
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Obtener el nombre del rol del usuario actual
function get_user_role_name($pdo, $rol_id) {
    $stmt = $pdo->prepare("SELECT Nombre_Rol FROM Rol WHERE ID_Rol = ?");
    $stmt->execute([$rol_id]);
    $rol = $stmt->fetch(PDO::FETCH_ASSOC);
    return $rol ? $rol['Nombre_Rol'] : 'Invitado';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido al Sistema de Gestión</h1>
        <nav>
            <ul>
                <?php if (is_logged_in()): ?>
                    <li><a href="dashboard/">Dashboard</a></li>
                    <li><a href="auth/logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="auth/login.php">Iniciar Sesión</a></li>
                    <li><a href="auth/register.php">Registrarse</a></li>
                <?php endif; ?>
                <li><a href="#acerca-de">Acerca de la Empresa</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="inicio">
            <h2>Inicio</h2>
            <?php if (is_logged_in()): ?>
                <p>Hola, <?= htmlspecialchars($_SESSION['nombre']) ?>.</p>
                <p>Tu rol es: <?= htmlspecialchars(get_user_role_name($pdo, $_SESSION['rol'])) ?>.</p>
            <?php else: ?>
                <p>Bienvenido, invitado.</p>
                <p>Inicia sesión o regístrate para acceder a más funcionalidades.</p>
            <?php endif; ?>
        </section>

        <section id="acerca-de">
            <h2>Acerca de la Empresa</h2>
            <p>Somos una empresa dedicada a ofrecer soluciones integrales para la gestión de operaciones comerciales. Nuestro sistema es seguro, eficiente y fácil de usar.</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Sistema de Gestión Comercial. Todos los derechos reservados.</p>
    </footer>
</body>
</html>