<nav>
    <ul>
        <li><a href="/index.php">Inicio</a></li>
        <li><a href="/acercade.php">Acerca de</a></li>
        <li><a href="/pages/facturacion/">Facturación</a></li>
        <li><a href="/pages/mantenimientos/">Mantenimiento</a></li>
        <li><a href="/pages/reportes/">Reportes</a></li>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <li><a href="/dashboard/crear_editar_usuario.php">Dashboard</a></li>
            <li class="user-info">
                <?= htmlspecialchars($_SESSION['nombre']) ?> 
                (<a href="/auth/logout.php">Salir</a>)
            </li>
        <?php else: ?>
            <li><a href="/auth/login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>