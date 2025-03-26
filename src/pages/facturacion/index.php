
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Facturación</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php include_once __DIR__ . '/../../../includes/navbar.php'; ?>
    <nav>
    <ul>
        <li><a href="/index.php">Inicio</a></li>
        <li><a href="/acercade.php">Acerca de</a></li>
        <li><a href="/pages/facturacion/index.php">Facturación</a></li>
        <li><a href="/pages/mantenimientos/clientes.php">Mantenimiento</a></li>
        <li><a href="/pages/reportes/clientes.php">Reportes</a></li>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <li><a href="/dashboard/dashboard.php">Dashboard</a></li>
            <li class="user-info">
                <?= htmlspecialchars($_SESSION['nombre']) ?> 
                (<a href="/auth/logout.php">Salir</a>)
            </li>
        <?php else: ?>
            <li><a href="/auth/login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
    <main>
        <h1>Facturación</h1>
        <p>Bienvenido al módulo de facturación (Acceso solo para Contabilidad)</p>
        
        <!-- Contenido específico de facturación aquí -->
    </main>
</body>
</html>