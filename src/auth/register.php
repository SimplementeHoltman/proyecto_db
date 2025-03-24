<?php
require_once __DIR__ . '/../includes/middleware.php';
requireRole(['Superadmin']);
header("Location: /dashboard/crear_editar_usuario.php");
exit;
?>