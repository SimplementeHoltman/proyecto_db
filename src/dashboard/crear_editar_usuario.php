<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    require_once __DIR__ . '/../includes/middleware.php';
    requireRole(['Superadmin']);
    require_once __DIR__ . '/../includes/db.php';
    require_once __DIR__ . '/../includes/functions.php';


    $usuario = null;
    $edicion = false;

    // Obtener usuario si estamos editando
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("SELECT * FROM Usuario WHERE ID_Usuario = ?");
        $stmt->execute([$_GET['id']]);
        $usuario = $stmt->fetch();
        $edicion = !empty($usuario);
    }

    // Obtener roles disponibles
    $stmtRoles = $pdo->query("SELECT * FROM Rol");
    $roles = $stmtRoles->fetchAll();

    // Procesar formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = sanitizeInput($_POST['nombre']);
        $apellido = sanitizeInput($_POST['apellido']);
        $correo = sanitizeInput($_POST['correo']);
        $password = $_POST['password'];
        $rol = (int)sanitizeInput($_POST['rol']);

        // Validaciones básicas
        if (empty($nombre) || empty($apellido) || empty($correo)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        if (!$edicion && empty($password)) {
            throw new Exception("La contraseña es obligatoria para nuevos usuarios");
        }

        // Verificar rol válido
        $stmtCheckRol = $pdo->prepare("SELECT ID_Rol FROM Rol WHERE ID_Rol = ?");
        $stmtCheckRol->execute([$rol]);
        if (!$stmtCheckRol->fetch()) {
            throw new Exception("Rol seleccionado no válido");
        }

        // Hash de contraseña si es necesario
        $hashedPassword = null;
        if (!empty($password)) {
            $hashedPassword = hashPassword($password);
        }

        // Construir consulta
        if ($edicion) {
            $sql = "UPDATE Usuario SET 
                    Nombre = ?,
                    Apellido = ?,
                    Correo = ?,
                    ID_Rol = ?".
                    ($hashedPassword ? ", Contraseña = ?" : "")."
                    WHERE ID_Usuario = ?";

            $params = [$nombre, $apellido, $correo, $rol];
            if ($hashedPassword) $params[] = $hashedPassword;
            $params[] = $usuario['ID_Usuario'];
        } else {
            $sql = "INSERT INTO Usuario 
                    (Nombre, Apellido, Correo, Contraseña, ID_Rol)
                    VALUES (?, ?, ?, ?, ?)";
            $params = [$nombre, $apellido, $correo, $hashedPassword, $rol];
        }

        // Ejecutar consulta
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $_SESSION['success'] = $edicion ? "Usuario actualizado correctamente" : "Usuario creado exitosamente";
        header("Location: usuarios.php");
        exit();

    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $edicion ? 'Editar' : 'Crear' ?> Usuario</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php include_once '../includes/navbar.php'; ?>
    
    <main>
        <h1><?= $edicion ? 'Editar Usuario' : 'Nuevo Usuario' ?></h1>

        <?php if(isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div>
                <label>Nombre:</label>
                <input type="text" name="nombre" required 
                    value="<?= htmlspecialchars($usuario['Nombre'] ?? '') ?>">
            </div>
            
            <div>
                <label>Apellido:</label>
                <input type="text" name="apellido" required
                    value="<?= htmlspecialchars($usuario['Apellido'] ?? '') ?>">
            </div>
            
            <div>
                <label>Correo electrónico:</label>
                <input type="email" name="correo" required
                    value="<?= htmlspecialchars($usuario['Correo'] ?? '') ?>">
            </div>
            
            <div>
                <label>Contraseña:</label>
                <input type="password" name="password" <?= !$edicion ? 'required' : '' ?>>
                <?php if($edicion): ?>
                    <small>Dejar en blanco para mantener la contraseña actual</small>
                <?php endif; ?>
            </div>
            
            <div>
                <label>Rol:</label>
                <select name="rol" required>
                    <?php foreach($roles as $rolOption): ?>
                        <option value="<?= $rolOption['ID_Rol'] ?>"
                            <?= ($rolOption['ID_Rol'] == ($usuario['ID_Rol'] ?? '')) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($rolOption['Nombre_Rol']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="btn-guardar"><?= $edicion ? 'Actualizar' : 'Crear' ?></button>
            <a href="usuarios.php" class="btn-cancelar">Cancelar</a>
        </form>
    </main>
</body>
</html>