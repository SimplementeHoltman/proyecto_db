<?php
$host = 'localhost'; // El servidor MySQL
$dbname = 'seguridad_db'; // Nombre de la base de datos
$username = 'dev'; // Usuario creado
$password = 'securepass'; // Contraseña del usuario

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
