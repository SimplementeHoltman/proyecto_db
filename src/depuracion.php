<?php
require_once __DIR__ . '/includes/db.php'; // Asegúrate de que la ruta sea correcta

try {
    // Verificar conexión
    if ($pdo) {
        echo "<p style='color: green;'>Conexión a la base de datos establecida correctamente.</p>";
    } else {
        throw new Exception("Error: No se pudo conectar a la base de datos.");
    }

    // Ejecutar una consulta simple para verificar que la base de datos funciona
    $stmt = $pdo->query("SELECT 1");
    if ($stmt->fetchColumn()) {
        echo "<p style='color: green;'>La base de datos responde correctamente.</p>";
    } else {
        throw new Exception("Error: La base de datos no respondió como se esperaba.");
    }

    // Verificar la existencia de la tabla "Rol" (opcional)
    $stmt = $pdo->query("SHOW TABLES LIKE 'Rol'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>La tabla 'Rol' existe en la base de datos.</p>";
    } else {
        echo "<p style='color: orange;'>Advertencia: La tabla 'Rol' no existe. Asegúrate de haber ejecutado el script de la base de datos.</p>";
    }

} catch (PDOException $e) {
    echo "<p style='color: red;'>Error de conexión a la base de datos: " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>