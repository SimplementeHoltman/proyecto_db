<?php
$host = 'localhost'; // El servidor MySQL
$dbname = 'seguridad_db'; // Nombre de la base de datos
$username = 'dev'; // Usuario creado
$password = 'securepass'; // Contraseña del usuario

try {
    // Crear la conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>