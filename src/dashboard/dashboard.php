<?php
require_once __DIR__ . '/../includes/middleware.php';
requireRole(['Superadmin', 'Técnico']);
require_once __DIR__ . '/../includes/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Superadmin</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php include_once '../includes/navbar.php'; ?>
    
    <main class="dashboard-container">
        <h1>Panel de Administración</h1>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="grid-container">
            <!-- Tarjeta de Gestión de Usuarios -->
            <div class="card">
                <h2>Gestión de Usuarios</h2>
                <p>Administra todos los usuarios del sistema</p>
                <div class="card-actions">
                    <a href="usuarios.php" class="btn">
                        <span class="icon">👥</span>
                        Ver Usuarios
                    </a>
                    <a href="crear_editar_usuario.php" class="btn btn-success">
                        <span class="icon">+</span>
                        Nuevo Usuario
                    </a>
                </div>
            </div>

            <!-- Tarjeta de Edición Rápida 
            <div class="card">
                <h2>Acciones Rápidas</h2>
                <p>Búsqueda directa de usuario para edición</p>
                <form action="usuarios.php" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Buscar usuario por email">
                    <button type="submit" class="btn">
                        <span class="icon">🔍</span>
                        Buscar
                    </button>
                </form>
            </div>-->
        </div>
    </main>
</body>
</html>