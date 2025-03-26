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