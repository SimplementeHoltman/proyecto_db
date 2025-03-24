<?php
// Agregar al inicio para ver errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/middleware.php';
requireRole(['Superadmin']);
require_once __DIR__ . '/../includes/db.php';

try {
    // Consulta SQL modificada
    $stmt = $pdo->query("
        SELECT 
            u.ID_Usuario,
            u.Nombre,
            u.Apellido,
            u.Correo,
            r.Nombre_Rol as Rol,
            u.Estado
        FROM Usuario u
        JOIN Rol r ON u.ID_Rol = r.ID_Rol
        ORDER BY u.ID_Usuario DESC
    ");
    
    if (!$stmt) {
        throw new Exception("Error en la consulta SQL");
    }
    
    $usuarios = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
} catch (Exception $e) {
    die("Error general: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php include_once '../includes/navbar.php'; ?>
    
    <main>
        <h1>Usuarios Registrados</h1>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="error"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuarios as $usuario): ?>
                    <tr class="<?= $usuario['Estado'] === 'Inactivo' ? 'inactivo' : '' ?>">
                        <td><?= htmlspecialchars($usuario['Nombre'] . ' ' . $usuario['Apellido']) ?></td>
                        <td><?= htmlspecialchars($usuario['Correo']) ?></td>
                        <td><?= htmlspecialchars($usuario['Rol']) ?></td>
                        <td>
                            <span class="estado <?= strtolower($usuario['Estado']) ?>">
                                <?= htmlspecialchars($usuario['Estado']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if($usuario['Estado'] === 'Activo'): ?>
                                <a href="crear_editar_usuario.php?id=<?= $usuario['ID_Usuario'] ?>" class="btn-editar">Editar</a>
                                <a href="eliminar_usuario.php?id=<?= $usuario['ID_Usuario'] ?>" 
                                   onclick="return confirm('¿Desactivar este usuario?')" 
                                   class="btn-desactivar">Desactivar</a>
                            <?php else: ?>
                                <form action="activar_usuario.php" method="POST" class="form-reactivar">
                                    <input type="hidden" name="id" value="<?= $usuario['ID_Usuario'] ?>">
                                    <button type="submit" class="btn-reactivar">Reactivar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>